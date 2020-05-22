<?php

namespace Zerdo\LaravelMJML;

use Illuminate\Notifications\Messages\MailMessage;

class MJMLMessage extends MailMessage
{
    /**
     * MJML
     */
    public $mjml;

    /**
     * Set the MJML Property.
     */
    public function mjml($view, array $data = [])
    {
        $this->mjml = $view;
        $this->view = $this->markdown = null;
        $this->viewData = $data;

        return $this;
    }
}
