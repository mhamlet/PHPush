<?php

namespace PHPush\providers\android;

use PHPush\providers\Device;

class Provider implements \PHPush\providers\Provider {

    private $access_key = '';

    /**
     * Setting Access Key
     *
     * @param string $access_key
     *
     * @throws \Exception
     */
    public function setAccessKey($access_key) {

        // If empty access key, throw an error
        if (empty($access_key)) throw new \Exception("Access Key Needed.");

        // Save access key
        $this->access_key = $access_key;
    }

    /**
     * Not using for this provider
     *
     * @param string $certificate
     *
     * @throws \Exception
     */
    public function setCertificate($certificate) {

        // If empty access key, throw an error
        if (empty($certificate)) throw new \Exception("You cannot set certificate for this provider.");
    }

    /**
     * Send message to devices
     *
     * @param string $message
     * @param Device $devices
     */
    public function send($message, $devices) {
        // TODO: Implement send() method.
    }
}