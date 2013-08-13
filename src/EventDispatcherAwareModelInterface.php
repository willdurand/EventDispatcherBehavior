<?php

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherAwareModelInterface
{
    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public static function setEventDispatcher(EventDispatcherInterface $eventDispatcher);

    /**
     * @return EventDispatcherInterface
     */
    public static function getEventDispatcher();
}
