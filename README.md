<div align="center">
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

###Usage for Lumen
This package does work with Lumen but there is an extra step that you have to take.

- Navigate to `bootstrap/app.php`.
- Add the following line: `$app->configure('laravel-mjml');`