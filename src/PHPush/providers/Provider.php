<?php

namespace PHPush\providers;

/**
 * Interface Provider
 *
 * @package PHPush\providers
 */
interface Provider {

    /**
     * Setting Access Key for provider (if needed)
     *
     * @param string $access_key
     *
     * @throws \Exception
     */
    public function setAccessKey($access_key);

    /**
     * Setting provider certificate (if needed)
     *
     * @param string $certificate
     *
     * @throws \Exception
     */
    public function setCertificate($certificate);

    /**
     * Send message to devices
     *
     * @param string $message
     * @param Device $devices
     * @param array $custom_fields
     */
    public function send($message, $devices, $custom_fields = array());
}
