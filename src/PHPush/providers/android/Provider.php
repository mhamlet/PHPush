<?php

namespace PHPush\providers\android;

use PHPush\providers\Device;

/**
 * Class Provider
 *
 * @package PHPush\providers\android
 */
class Provider implements \PHPush\providers\Provider {

    /**
     * Google Access Key
     *
     * @var string
     */
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
     * @param Device[] $devices
     * @param array  $custom_fields
     */
    public function send($message, $devices, $custom_fields = array()) {

        // If list of devices is empty, then we must terminate this process
        if (empty($devices)) return;

        // Setting an empty $registration_ids
        $registration_ids = array();

        // For each device
        foreach ($devices as $device) {

            // Save registration ID of device
            $registration_ids[] = $device->getDeviceToken();
        }

        // Saving basic data
        $data = ['message' => $message];

        // Merging data with custom fields
        $data = array_merge($data, $custom_fields);

        // Saving fields
        $fields = ['registration_ids' => $registration_ids, 'data' => $data];

        // Setting headers
        $headers = ['Authorization: key=' . $this->access_key, 'Content-Type: application/json'];

        // Processing request to Google to send the push
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_exec($ch);
        curl_close($ch);
    }
}