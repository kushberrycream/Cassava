<?php

namespace _JchOptimizeVendor\Laminas\EventManager;

/**
 * Abstract aggregate listener.
 */
abstract class AbstractListenerAggregate implements ListenerAggregateInterface
{
    /** @var callable[] */
    protected $listeners = [];

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $callback) {
            $events->detach($callback);
            unset($this->listeners[$index]);
        }
    }
}
