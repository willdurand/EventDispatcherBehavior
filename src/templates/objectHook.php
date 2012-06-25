self::getEventDispatcher()->dispatch('<?php echo $eventName ?>', new GenericEvent($this));
