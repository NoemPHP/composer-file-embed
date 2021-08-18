# Examples

Note: The `[embedmd]:#`-prefix is omitted in the following examples, showing only the actual embed definition. This is
to prevent them from disappearing in the generated document as well as to prevent triggering duplicate embeds.

### Include a full php file with automatic syntax highlighting

`(./embed/FooInterface.php)`

[embedmd]:# (./embed/FooInterface.php)
```php
<?php

namespace Acme\Stuff;

use Foo\Bar\Baz;
use Foo\Bar\Baz2;
use Foo\Bar\Baz3;
use Foo\Bar\Baz4;
use Foo\Bar\Baz5;

/**
 * Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
 * sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
 * sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
 * Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
 * Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
 * sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
 * sed diam voluptua.
 *
 * At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,
 * no sea takimata sanctus est Lorem ipsum dolor sit amet.
 */
interface FooInterface
{

    /**
     * A very good doc block!
     */
    public function doSomething(): void;
}

```

### Include only the actual interface definition of the file above

`(./embed/FooInterface.php php interface.*})`

[embedmd]:# (./embed/FooInterface.php php interface.*})
```php
interface FooInterface
{

    /**
     * A very good doc block!
     */
    public function doSomething(): void;
}
```
### Include the 'Thanks' section via regex matching

`(./README.md markdown ##\sThanks.*$)`

[embedmd]:# (./README.md markdown ##\sThanks.*$)
```markdown
## Thanks

* @campoy for [campoy/embedmd](https://github.com/campoy/embedmd) which was a huge inspiration.

```