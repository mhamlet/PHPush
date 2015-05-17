<?php

namespace PHPush\providers;

/**
 * Interface Device
 *
 * @package PHPush\providers
 */
interface Device {

    /**
     * Setting device token
     *
     * @param string $device_token
     */
    public function __construct($device_token);

    /**
     * Returns provider of device
     *
     * @return string
     */
    public function getProvider();

    /**
     * Getting device token
     *
     * @return string
     */
    public function getDeviceToken();
}
