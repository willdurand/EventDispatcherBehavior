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
            'construct',
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
        $script .= $this->addDummyConstruct();

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

    public function addDummyConstruct()
    {
        return $this->behavior->renderTemplate('objectDummyConstruct');
    }

    public function addConstructHook()
    {
        return '    ' . $this->behavior->renderTemplate('objectHook', array(
            'eventName' => $this->getEventName('construct'),
        )) . '    ';
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

        // rename the dummy_construct to __construct if __construct does not exists
        if (strpos($script, 'function __construct') === false) {
            $script = str_replace('function dummy_construct', 'function __construct', $script);
        }

        $parser = new PropelPHPParser($script, true);
        $parser->removeMethod('dummy_construct');
        $oldCode = $parser->findMethod('__construct');
        $newCode = substr_replace($oldCode, $this->addConstructHook() . '}', strrpos($oldCode, '}'));
        $parser->replaceMethod('__construct', $newCode);
        $script = $parser->getCode();
    }

    protected function getEventName($eventName)
    {
        return 'propel.' . $eventName ;
    }
}
