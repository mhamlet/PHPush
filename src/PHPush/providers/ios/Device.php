<?php


namespace PHPush\providers\ios;


/**
 * Class Device
 *
 * @package PHPush\providers\ios
 */
class Device implements \PHPush\providers\Device {

    /**
     * Device token
     *
     * @var string
     */
    protected $device_token;

    /**
     * Setting device token
     *
     * @param string $device_token
     */
    public function __construct($device_token) {

        // Saving device token
        $this->device_token = $device_token;
    }

    /**
     * Returns provider of device
     *
     * @return string
     */
    public function getProvider() {

        // Returning android
        return \PHPush\Provider::PROVIDER_IOS;
    }

    /**
     * Getting device token
     *
     * @return string
     */
    public function getDeviceToken() {

        // Returning device token
        return $this->device_token;
    }
}