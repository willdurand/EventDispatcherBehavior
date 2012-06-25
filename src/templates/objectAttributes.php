<?php foreach ($events as $constant => $eventName) : ?>

const <?php echo $constant ?> = '<?php echo $eventName ?>';
<?php endforeach; ?>

/**
 * @var \Symfony\Component\EventDispatcher\EventDispatcher
 */
static private $dispatcher = null;
