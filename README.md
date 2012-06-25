EventDispatcherBehavior
=======================

[![Build Status](https://secure.travis-ci.org/willdurand/EventDispatcherBehavior.png?branch=master)](http://travis-ci.org/willdurand/EventDispatcherBehavior)

Integrate the Symfony2 [EventDispatcher](https://github.com/symfony/EventDispatcher) component in your Model classes.


### Installation ###

Requires this behavior in your `composer.json`:

```js
{
    "require": {
        "willdurand/propel-eventdispatcher-behavior": "dev-master"
    }
}
```

Add the following line to your `propel.ini` or `build.properties` configuration
file:

```ini
propel.behavior.eventdispatcher.class = vendor.willdurand.propel-eventdispatcher-behavior.src.EventDispatcherBehavior
```

>Note: `vendor.willdurand.propel-eventdispatcher-behavior.src` is the path of the
>behavior in dot-path notation.

Finally, adds this behavior to your `schema.xml`:

```xml
<database name="foo">
    <table name="a-table">
        <behavior name="eventdispatcher" />
    </table>
</database>
```


### ActiveRecord API ###

This behavior adds a single method `getEventDispatcher()`.
This method creates an instance of
[`EventDispatcher`](https://github.com/symfony/EventDispatcher/blob/master/EventDispatcher.php)
per class.


### Running tests ###

Install dependencies:

    php composer.phar install --dev

Run the test suite:

    phpunit


### License ###

This behavior is released under the MIT License. See the bundled LICENSE file for details.
