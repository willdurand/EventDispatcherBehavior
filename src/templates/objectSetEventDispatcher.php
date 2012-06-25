
/**
 * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface
 */
static public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
{
    self::$dispatcher = $eventDispatcher;
}
