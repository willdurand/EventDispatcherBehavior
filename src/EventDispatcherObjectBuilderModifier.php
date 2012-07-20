<?php

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class EventDispatcherObjectBuilderModifier
{
    private $behavior;

    public function __construct(Behavior $behavior)
    {
        $this->behavior = $behavior;
    }

    public function objectAttributes($builder)
    {
        $events = array();
        foreach (array(
            'pre_save', 'post_save',
            'pre_update', 'post_update',
            'pre_insert', 'post_insert',
            'pre_delete', 'post_delete'
        ) as $eventName) {
            $constant = strtoupper('EVENT_' . $eventName);
            $events[$constant] = $this->getEventName($eventName);
        }

        return $this->behavior->renderTemplate('objectAttributes', array(
            'events' => $events,
        ));
    }

    public function objectMethods($builder)
    {
        // declare this class for hooks
        $builder->declareClass('Symfony\Component\EventDispatcher\GenericEvent');
        $builder->declareClass('EventDispatcherAwareModelInterface');

        $script = '';
        $script .= $this->addGetEventDispatcher($builder);
        $script .= $this->addSetEventDispatcher($builder);

        return $script;
    }

    public function addGetEventDispatcher($builder)
    {
        $builder->declareClass('Symfony\Component\EventDispatcher\EventDispatcher');

        return $this->behavior->renderTemplate('objectGetEventDispatcher');
    }

    public function addSetEventDispatcher($builder)
    {
        $builder->declareClass('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        return $this->behavior->renderTemplate('objectSetEventDispatcher');
    }

    public function preSave()
    {
        return $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('pre_save'),
        ));
    }

    public function postSave()
    {
        return $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('post_save'),
        ));
    }

    public function preUpdate()
    {
        return $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('pre_update'),
        ));
    }

    public function postUpdate()
    {
        return $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('post_update'),
        ));
    }

    public function preInsert()
    {
        return $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('pre_insert'),
        ));
    }

    public function postInsert()
    {
        return $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('post_insert'),
        ));
    }

    public function preDelete()
    {
        return $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('pre_delete'),
        ));
    }

    public function postDelete()
    {
        return $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('post_delete'),
        ));
    }

    public function objectFilter(&$script)
    {
        $script = preg_replace('#(implements Persistent)#', '$1, EventDispatcherAwareModelInterface', $script);
    }

    protected function getEventName($eventName)
    {
        return 'propel.' . $eventName ;
    }
}
