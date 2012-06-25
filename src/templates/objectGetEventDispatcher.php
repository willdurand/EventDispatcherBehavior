
/**
 * @return \Symfony\Component\EventDispatcher\EventDispatcher
 */
static public function getEventDispatcher()
{
    if (null === self::$dispatcher) {
        self::$dispatcher = new EventDispatcher();
    }

    return self::$dispatcher;
}
