<?php

namespace _JchOptimizeVendor\Illuminate\Bus;

class UpdatedBatchJobCounts
{
    /**
     * The number of pending jobs remaining for the batch.
     *
     * @var int
     */
    public $pendingJobs;

    /**
     * The number of failed jobs that belong to the batch.
     *
     * @var int
     */
    public $failedJobs;

    /**
     * Create a new batch job counts object.
     */
    public function __construct(int $pendingJobs = 0, int $failedJobs = 0)
    {
        $this->pendingJobs = $pendingJobs;
        $this->failedJobs = $failedJobs;
    }

    /**
     * Determine if all jobs have run exactly once.
     *
     * @return bool
     */
    public function allJobsHaveRanExactlyOnce()
    {
        return 0 === $this->pendingJobs - $this->failedJobs;
    }
}
