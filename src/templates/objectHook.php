self::getEventDispatcher()->dispatch('<?php echo $eventName ?>', new GenericEvent($this<?php if ($withConnection) : ?>, array('connection' => $con)<?php endif; ?>));
