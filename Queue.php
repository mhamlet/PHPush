<?php

namespace PHPush;

class Queue {

    /**
     * List of all devices in queue
     *
     * @var array
     */
    private $devices = [];

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

        // Save list of devices
        $this->devices = array_merge($this->devices, $devices);

        return $this;
    }
}