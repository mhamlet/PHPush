<?php

namespace PHPush\providers\ios;

use PHPush\providers\Device;

class Provider implements \PHPush\providers\Provider {

    private $certificate = '';

    /**
     * Not using for this provider
     *
     * @param string $access_key
     *
     * @throws \Exception
     */
    public function setAccessKey($access_key) {

        // If empty access key, throw an error
        if (empty($access_key)) throw new \Exception("You cannot set access key for this provider.");
    }

    /**
     * Not using for this provider
     *
     * @param string $certificate
     *
     * @throws \Exception
     */
    public function setCertificate($certificate) {

        // If empty certificate, throw an error
        if (empty($certificate)) throw new \Exception("Access Key Needed.");

        // Save certificate
        $this->certificate = $certificate;
    }

    /**
     * Send message to devices
     *
     * @param string $message
     * @param Device $devices
     * @param array  $custom_fields
     */
    public function send($message, $devices, $custom_fields = []) {
        // TODO: Implement send() method.
    }
}