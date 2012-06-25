
/**
 * @return \Symfony\Component\EventDispatcher\EventDispatcher
 */
static public function getEventDispatcher()
{
    if (null === self::$dispatcher) {
        self::setEventDispatcher(new EventDispatcher());
    }

    return self::$dispatcher;
}
