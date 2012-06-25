<?php

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class EventDispatcherBehavior extends Behavior
{
    /**
     * @var EventDispatcherObjectBuilderModifier
     */
    private $objectBuilderModifier;

    /**
     * {@inheritdoc}
     */
    public function getObjectBuilderModifier()
    {
        if (null === $this->objectBuilderModifier) {
            $this->objectBuilderModifier = new EventDispatcherObjectBuilderModifier($this);
        }

        return $this->objectBuilderModifier;
    }
}
