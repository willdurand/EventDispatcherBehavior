<?php

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherAwareModelInterface
{
    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    static public function setEventDispatcher(EventDispatcherInterface $eventDispatcher);

    /**
     * @return EventDispatcherInterface
     */
    static public function getEventDispatcher();
}
