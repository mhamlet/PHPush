<?php

namespace PHPush;

/**
 * Class Queue
 *
 * @package PHPush
 */
class Queue {

    /**
     * List of all devices in queue
     *
     * @var array
     */
    private $devices = [];

    /**
     * Message to send
     *
     * @var string
     */
    private $message = '';

    /**
     * Custom data to send
     *
     * @var array
     */
    private $custom_data = [];

    /**
     * Add devices to queue
     *
     * @param providers\Device|array $devices
     *
     * @return $this
     */
    public function add($devices) {

        // If device is not array, save it in array
        if (!is_array($devices)) $devices = [$devices];

        // Process all devices
        foreach ($devices as $device) {

            // Getting device provider
            $provider = $device->getProvider();

            // Save the device
            $this->devices[$provider][] = $device;
        }

        return $this;
    }

    /**
     * Setting message to send
     *
     * @param       $text
     * @param array $custom_data
     *
     * @return $this
     */
    public function message($text, $custom_data = []) {

        // Setting message
        $this->message = $text;

        // Setting custom data
        $this->custom_data = $custom_data;

        return $this;
    }

    /**
     * Send a message to all devices in current queue
     *
     * @param array $custom_fields
     *
     * @throws \Exception
     */
    public function send($custom_fields = array()) {

        // Check if message is not empty
        if (empty($this->message)) throw new \Exception('Message cannot be empty.');

        // For each provider
        foreach ($this->devices as $provider => $devices) {

            // Getting provider
            $provider = PHPush::Provider($provider);

            // Sending to all devices
            $provider->send($this->message, $devices, $custom_fields);
        }
    }
}