<div align="center">
  <sup>
  <br />
  <br />
  <pre>composer require zerdo/laravel-mjml</pre>
  <br />
  <br />
</div>

#### Basic Usage

##### `MJMLChannel`

Use `MJMLChannel` when you want to send a email via the MJML api.

```php
<?php

use Zerdo\LaravelMJML\MJMLChannel;

class OrderNotification extends Notification implements ShouldQueue {
    ...

    public function via()
    {
        return [MJMLChannel::class];
    }
}
```

##### `MJMLMessage`

Use `MJMLMessage` when you want to construct a blade view using MJML components.

```php
<?php

use Zerdo\LaravelMJML\MJMLMessage;

class OrderNotification extends Notification implements ShouldQueue {
    ...
    public function toMail()
    {
        return (new MJMLMessage)->subject('...')->mjml('emails.mjml-template');
    }
}
```