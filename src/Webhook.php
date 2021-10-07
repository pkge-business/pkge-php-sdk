<?php namespace Pkge;

use Pkge\Entities\Webhooks\Event;
use Pkge\Exceptions\WebhookSignatureException;

class Webhook
{
    private $webhookSecret;

    /**
     * Webhook constructor.
     * @param string $webhookSecret
     */
    public function __construct($webhookSecret)
    {
        $this->webhookSecret = $webhookSecret;
    }

    /**
     * @param $requestBody
     * @param $signature
     * @return Event
     * @throws \Pkge\Exceptions\WebhookSignatureException
     */
    public function handleEvent($requestBody, $signature)
    {
        $this->verifySignature($requestBody, $signature);

        $body = json_decode($requestBody, true);

        return new Event($body);
    }

    /**
     * @param $data
     * @param $signature
     * @throws \Pkge\Exceptions\WebhookSignatureException
     */
    private function verifySignature($data, $signature)
    {
        $validSignature = $this->createSignature($data);

        if ($validSignature !== base64_decode($signature)) {
            throw new WebhookSignatureException('Invalid webhook secret or request signature.');
        }
    }

    /**
     * @param $data
     * @param $secret
     * @return string
     */
    private function createSignature($data)
    {
        return hash_hmac('SHA256', $data, $this->webhookSecret, true);
    }
}