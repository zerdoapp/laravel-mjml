<?php

namespace Zerdo\LaravelMJML;

use InvalidArgumentException;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Channels\MailChannel;

class MJMLChannel extends MailChannel
{
    /**
     * Render the mjml.
     */
    protected function mjml($message)
    {
        $mjml = view($message->mjml, $message->data())->render();

        $api = (new Client())
            ->setApplicationId($this->getApplicationId())
            ->setSecretKey($this->getSecretKey());

        return ['html' => new HtmlString($api->render($mjml))];
    }

    /**
     * Build the view
     */
    protected function buildView($message): array
    {
        if ($message->mjml) {
            return $this->mjml($message);
        }

        return parent::buildView($message);
    }

    /**
     * Render the view.
     */
    public function render($message)
    {
        if (is_string($view = $this->buildView($message))) {
            return view($view, $message->data());
        }

        if (isset($view['html'])) {
            return $view['html'];
        }

        throw new InvalidArgumentException('Could not render message [' . get_class($message) . ']');
    }

    /**
     * Get the application id from the config.
     */
    protected function getApplicationId(): string
    {
        return config('laravel-mjml.app_key');
    }

    /**
     * Get the secret key from the config.
     */
    protected function getSecretKey(): string
    {
        return config('laravel-mjml.secret_key');
    }
}
