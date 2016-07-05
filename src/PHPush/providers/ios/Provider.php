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
    protected $certificate = '';

    protected $stream_socket = null;

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
    public function send($message, $devices, $custom_fields = array()) {

        // If list of devices is empty, then we must terminate this process
        if (empty($devices)) return;

        // Passphrase in default is phpush
        $passphrase = 'phpush';

        // If we setting passphrase in custom fields, then change it and delete from array
        if (array_key_exists('passphrase', $custom_fields)) {
            $passphrase = $custom_fields['passphrase'];
            unset($custom_fields['passphrase']);
        }

        // Create the payload body
        $body['aps'] = array_merge(
            array('alert' => $message, 'sound' => 'default'),
            $custom_fields
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // For each device
        foreach ($devices as $device) {

            // Get device token
            $device_token = $device->getDeviceToken();

            // Setting remote socket
            $remote_path = 'ssl://gateway.push.apple.com:2195';

            // If we are in development environment
            if (PHPush::Environment() == PHPush::ENVIRONMENT_DEVELOPMENT) {

                // Change to development remote socket
                $remote_path = 'ssl://gateway.sandbox.push.apple.com:2195';
            }

            $stream_socket = $this->get_stream_socket($remote_path, $passphrase);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            fwrite($stream_socket, $msg, strlen($msg));
        }
    }

    /**
     * Opens connection to remote server
     *
     * @param string $remote_path
     *
     * @return null|resource
     */
    protected function get_stream_socket($remote_path, $passphrase) {

        if (is_null($this->stream_socket)) {

            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $this->certificate);
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            $this->stream_socket = stream_socket_client($remote_path, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        }

        return $this->stream_socket;
    }

    public function __destruct() {

        // Close the connection to the server
        if (!is_null($this->stream_socket)) {
            fclose($this->stream_socket);
        }
    }
}