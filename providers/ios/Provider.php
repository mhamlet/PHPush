<?php

namespace PHPush\providers\ios;

use PHPush\PHPush;
use PHPush\providers\Device;

/**
 * Class Provider
 *
 * @package PHPush\providers\ios
 */
class Provider implements \PHPush\providers\Provider {

    /**
     * Path to certificate
     *
     * @var string
     */
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
     * @param Device[] $devices
     * @param array  $custom_fields
     */
    public function send($message, $devices, $custom_fields = []) {

        // If list of devices is empty, then we must terminate this process
        if (empty($devices)) return;

        // Passphrase in default is phpush
        $passphrase = 'phpush';

        // If we setting passphrase in custom fields, then change it and delete from array
        if (array_key_exists('passphrase', $custom_fields)) {
            $passphrase = $custom_fields['passphrase'];
            unset($custom_fields['passphrase']);
        }

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->certificate);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Create the payload body
        $body['aps'] = array('alert' => $message, 'sound' => 'default');

        // Encode the payload as JSON
        $payload = json_encode($body);

        // For each device
        foreach ($devices as $device) {

            // Get device token
            $device_token = $device->getDeviceToken();

            // Setting remote socket
            $remote_socket = 'ssl://gateway.push.apple.com:2195';

            // If we are in development environment
            if (PHPush::Environment() == PHPush::ENVIRONMENT_DEVELOPMENT) {

                // Change to development remote socket
                $remote_socket = 'ssl://gateway.sandbox.push.apple.com:2195';
            }

            // Open stream socket
            $fp = stream_socket_client($remote_socket, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            fwrite($fp, $msg, strlen($msg));

            // Close the connection to the server
            fclose($fp);
        }
    }
}