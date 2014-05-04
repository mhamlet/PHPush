<?php

namespace PHPush;

class PHPush {

    /**
     * Current path
     */
    const PATH = __DIR__;

    /**
     * Is PHPush already initialized
     *
     * @var bool
     */
    private static $init = false;

    /**
     * Initializing PHPush
     */
    private static function init() {

        // Registering autoload
        spl_autoload_extensions(".php");
        spl_autoload_register();
    }

    /**
     * Check if provider exists
     *
     * @param $provider_name
     *
     * @return bool
     */
    private static function provider_exists($provider_name) {

        // Check all files
        // TODO: Add all files
        return (is_dir(PHPush::PATH . "providers/{$provider_name}")
            && file_exists(PHPush::PATH . "providers/{$provider_name}/Device.php")
            && file_exists(PHPush::PATH . "providers/{$provider_name}/Provider.php"));
    }

    /**
     * @param $provider_name
     *
     * @return providers\Provider
     * @throws \Exception
     */
    public static function Provider($provider_name) {

        // If PHPush doesn't initialized
        if (self::$init === FALSE) self::init();

        // Check if provider exists
        if (!self::provider_exists($provider_name)) throw new \Exception("Provider '{$provider_name}' not exists.");

        // Getting class name
        $class_name = "providers\\{$provider_name}\\Provider";

        // Returns provider's instance
        return new $class_name();
    }
}
