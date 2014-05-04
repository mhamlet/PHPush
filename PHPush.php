<?php

namespace PHPush;

// Including some files
require_once 'autoload.php';
require_once 'Provider.php';

class PHPush {

    /**
     * Check if provider exists
     *
     * @param $provider_name
     *
     * @return bool
     */
    private static function provider_exists($provider_name) {

        // Getting path
        $path = __DIR__;

        // Check all files
        // TODO: Add all files
        return (is_dir("$path/providers/{$provider_name}")
            && file_exists("$path/providers/{$provider_name}/Device.php")
            && file_exists("$path/providers/{$provider_name}/Provider.php"));
    }

    /**
     * @param $provider_name
     *
     * @return providers\Provider
     * @throws \Exception
     */
    public static function Provider($provider_name) {

        // Check if provider exists
        if (!self::provider_exists($provider_name)) throw new \Exception("Provider '{$provider_name}' does not exist.");

        // Getting class name
//        $class_name = "PHPush\\providers\\{$provider_name}\\Provider";

        // Returns provider's instance
        return new providers\android\Provider();
    }
}
