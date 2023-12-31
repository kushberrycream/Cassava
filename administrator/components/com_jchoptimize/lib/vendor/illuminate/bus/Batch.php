<?php

namespace _JchOptimizeVendor\Illuminate\Bus;

use _JchOptimizeVendor\Carbon\CarbonImmutable;
use _JchOptimizeVendor\Illuminate\Contracts\Queue\Factory as QueueFactory;
use _JchOptimizeVendor\Illuminate\Contracts\Support\Arrayable;
use _JchOptimizeVendor\Illuminate\Queue\CallQueuedClosure;
use _JchOptimizeVendor\Illuminate\Support\Arr;
use _JchOptimizeVendor\Illuminate\Support\Collection;

class Batch implements Arrayable, \JsonSerializable
{
    /**
     * The batch ID.
     *
     * @var string
     */
    public $id;

    /**
     * The batch name.
     *
     * @var string
     */
    public $name;

    /**
     * The total number of jobs that belong to the batch.
     *
     * @var int
     */
    public $totalJobs;

    /**
     * The total number of jobs that are still pending.
     *
     * @var int
     */
    public $pendingJobs;

    /**
     * The total number of jobs that have failed.
     *
     * @var int
     */
    public $failedJobs;

    /**
     * The IDs of the jobs that have failed.
     *
     * @var array
     */
    public $failedJobIds;

    /**
     * The batch options.
     *
     * @var array
     */
    public $options;

    /**
     * The date indicating when the batch was created.
     *
     * @var \Carbon\CarbonImmutable
     */
    public $createdAt;

    /**
     * The date indicating when the batch was cancelled.
     *
     * @var null|\Carbon\CarbonImmutable
     */
    public $cancelledAt;

    /**
     * The date indicating when the batch was finished.
     *
     * @var null|\Carbon\CarbonImmutable
     */
    public $finishedAt;

    /**
     * The queue factory implementation.
     *
     * @var \Illuminate\Contracts\Queue\Factory
     */
    protected $queue;

    /**
     * The repository implementation.
     *
     * @var \Illuminate\Bus\BatchRepository
     */
    protected $repository;

    /**
     * Create a new batch instance.
     *
     * @param \Illuminate\Contracts\Queue\Factory $queue
     * @param \Illuminate\Bus\BatchRepository     $repository
     * @param \Carbon\CarbonImmutable             $createdAt
     * @param null|\Carbon\CarbonImmutable        $cancelledAt
     * @param null|\Carbon\CarbonImmutable        $finishedAt
     */
    public function __construct(QueueFactory $queue, BatchRepository $repository, string $id, string $name, int $totalJobs, int $pendingJobs, int $failedJobs, array $failedJobIds, array $options, CarbonImmutable $createdAt, ?CarbonImmutable $cancelledAt = null, ?CarbonImmutable $finishedAt = null)
    {
        $this->queue = $queue;
        $this->repository = $repository;
        $this->id = $id;
        $this->name = $name;
        $this->totalJobs = $totalJobs;
        $this->pendingJobs = $pendingJobs;
        $this->failedJobs = $failedJobs;
        $this->failedJobIds = $failedJobIds;
        $this->options = $options;
        $this->createdAt = $createdAt;
        $this->cancelledAt = $cancelledAt;
        $this->finishedAt = $finishedAt;
    }

    /**
     * Dynamically access the batch's "options" via properties.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->options[$key] ?? null;
    }

    /**
     * Get a fresh instance of the batch represented by this ID.
     *
     * @return self
     */
    public function fresh()
    {
        return $this->repository->find($this->id);
    }

    /**
     * Add additional jobs to the batch.
     *
     * @param array|\Illuminate\Support\Enumerable $jobs
     *
     * @return self
     */
    public function add($jobs)
    {
        $count = 0;
        $jobs = Collection::wrap($jobs)->map(function ($job) use (&$count) {
            $job = $job instanceof \Closure ? CallQueuedClosure::create($job) : $job;
            if (\is_array($job)) {
                $count += \count($job);

                return with($this->prepareBatchedChain($job), function ($chain) {
                    return $chain->first()->allOnQueue($this->options['queue'] ?? null)->allOnConnection($this->options['connection'] ?? null)->chain($chain->slice(1)->values()->all());
                });
            } else {
                $job->withBatchId($this->id);
                ++$count;
            }

            return $job;
        });
        $this->repository->transaction(function () use ($jobs, $count) {
            $this->repository->incrementTotalJobs($this->id, $count);
            $this->queue->connection($this->options['connection'] ?? null)->bulk($jobs->all(), $data = '', $this->options['queue'] ?? null);
        });

        return $this->fresh();
    }

    /**
     * Get the total number of jobs that have been processed by the batch thus far.
     *
     * @return int
     */
    public function processedJobs()
    {
        return $this->totalJobs - $this->pendingJobs;
    }

    /**
     * Get the percentage of jobs that have been processed (between 0-100).
     *
     * @return int
     */
    public function progress()
    {
        return $this->totalJobs > 0 ? \round($this->processedJobs() / $this->totalJobs * 100) : 0;
    }

    /**
     * Record that a job within the batch finished successfully, executing any callbacks if necessary.
     */
    public function recordSuccessfulJob(string $jobId)
    {
        $counts = $this->decrementPendingJobs($jobId);
        if (0 === $counts->pendingJobs) {
            $this->repository->markAsFinished($this->id);
        }
        if (0 === $counts->pendingJobs && $this->hasThenCallbacks()) {
            $batch = $this->fresh();
            collect($this->options['then'])->each(function ($handler) use ($batch) {
                $this->invokeHandlerCallback($handler, $batch);
            });
        }
        if ($counts->allJobsHaveRanExactlyOnce() && $this->hasFinallyCallbacks()) {
            $batch = $this->fresh();
            collect($this->options['finally'])->each(function ($handler) use ($batch) {
                $this->invokeHandlerCallback($handler, $batch);
            });
        }
    }

    /**
     * Decrement the pending jobs for the batch.
     *
     * @return \Illuminate\Bus\UpdatedBatchJobCounts
     */
    public function decrementPendingJobs(string $jobId)
    {
        return $this->repository->decrementPendingJobs($this->id, $jobId);
    }

    /**
     * Determine if the batch has finished executing.
     *
     * @return bool
     */
    public function finished()
    {
        return !\is_null($this->finishedAt);
    }

    /**
     * Determine if the batch has "success" callbacks.
     *
     * @return bool
     */
    public function hasThenCallbacks()
    {
        return isset($this->options['then']) && !empty($this->options['then']);
    }

    /**
     * Determine if the batch allows jobs to fail without cancelling the batch.
     *
     * @return bool
     */
    public function allowsFailures()
    {
        return \true === Arr::get($this->options, 'allowFailures', \false);
    }

    /**
     * Determine if the batch has job failures.
     *
     * @return bool
     */
    public function hasFailures()
    {
        return $this->failedJobs > 0;
    }

    /**
     * Record that a job within the batch failed to finish successfully, executing any callbacks if necessary.
     *
     * @param \Throwable $e
     */
    public function recordFailedJob(string $jobId, $e)
    {
        $counts = $this->incrementFailedJobs($jobId);
        if (1 === $counts->failedJobs && !$this->allowsFailures()) {
            $this->cancel();
        }
        if (1 === $counts->failedJobs && $this->hasCatchCallbacks()) {
            $batch = $this->fresh();
            collect($this->options['catch'])->each(function ($handler) use ($batch, $e) {
                $this->invokeHandlerCallback($handler, $batch, $e);
            });
        }
        if ($counts->allJobsHaveRanExactlyOnce() && $this->hasFinallyCallbacks()) {
            $batch = $this->fresh();
            collect($this->options['finally'])->each(function ($handler) use ($batch, $e) {
                $this->invokeHandlerCallback($handler, $batch, $e);
            });
        }
    }

    /**
     * Increment the failed jobs for the batch.
     *
     * @return \Illuminate\Bus\UpdatedBatchJobCounts
     */
    public function incrementFailedJobs(string $jobId)
    {
        return $this->repository->incrementFailedJobs($this->id, $jobId);
    }

    /**
     * Determine if the batch has "catch" callbacks.
     *
     * @return bool
     */
    public function hasCatchCallbacks()
    {
        return isset($this->options['catch']) && !empty($this->options['catch']);
    }

    /**
     * Determine if the batch has "finally" callbacks.
     *
     * @return bool
     */
    public function hasFinallyCallbacks()
    {
        return isset($this->options['finally']) && !empty($this->options['finally']);
    }

    /**
     * Cancel the batch.
     */
    public function cancel()
    {
        $this->repository->cancel($this->id);
    }

    /**
     * Determine if the batch has been cancelled.
     *
     * @return bool
     */
    public function canceled()
    {
        return $this->cancelled();
    }

    /**
     * Determine if the batch has been cancelled.
     *
     * @return bool
     */
    public function cancelled()
    {
        return !\is_null($this->cancelledAt);
    }

    /**
     * Delete the batch from storage.
     */
    public function delete()
    {
        $this->repository->delete($this->id);
    }

    /**
     * Convert the batch to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return ['id' => $this->id, 'name' => $this->name, 'totalJobs' => $this->totalJobs, 'pendingJobs' => $this->pendingJobs, 'processedJobs' => $this->processedJobs(), 'progress' => $this->progress(), 'failedJobs' => $this->failedJobs, 'options' => $this->options, 'createdAt' => $this->createdAt, 'cancelledAt' => $this->cancelledAt, 'finishedAt' => $this->finishedAt];
    }

    /**
     * Get the JSON serializable representation of the object.
     *
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Prepare a chain that exists within the jobs being added.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function prepareBatchedChain(array $chain)
    {
        return collect($chain)->map(function ($job) {
            $job = $job instanceof \Closure ? CallQueuedClosure::create($job) : $job;

            return $job->withBatchId($this->id);
        });
    }

    /**
     * Invoke a batch callback handler.
     *
     * @param callable              $handler
     * @param \Illuminate\Bus\Batch $batch
     */
    protected function invokeHandlerCallback($handler, Batch $batch, \Throwable $e = null)
    {
        try {
            return $handler($batch, $e);
        } catch (\Throwable $e) {
            if (\function_exists('_JchOptimizeVendor\\report')) {
                report($e);
            }
        }
    }
}
