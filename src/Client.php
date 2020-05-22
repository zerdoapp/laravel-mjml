<?php

namespace Zerdo\LaravelMJML;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class Client
{
    /**
     * MJML Application ID.
     */
    protected string $appId;

    /**
     * MJML Secret Key.
     */
    protected string $secretKey;

    /**
     * The endpoint to hit the MJML servers with.
     */
    protected static $endpoint = 'https://api.mjml.io/v1';

    /**
     * GuzzleHttp Client.
     */
    protected GuzzleClient $client;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    /**
     * Set the MJML application id.
     */
    public function setApplicationId(string $appId): Client
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * Set the MJML secret key.
     */
    public function setSecretKey(string $secretKey): Client
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * Render the MJML that gets passed in.
     */
    public function render(string $mjml): ?string
    {
        $request = $this->request($mjml);

        if (property_exists($request, 'status_code') && $request->status_code !== 200) {
            return null;
        }

        return $request->html;
    }

    /**
     * Get the request response in JSON for rendering the MJML.
     */
    protected function request(string $mjml): object
    {
        try {
            $request = $this->client->request('POST', self::$endpoint . '/render', [
                'auth' => [$this->appId, $this->secretKey],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accepts' => 'application/json'
                ],
                RequestOptions::JSON => [
                    'mjml' => $mjml
                ]
            ]);
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }

        return json_decode($request->getBody());
    }
}
