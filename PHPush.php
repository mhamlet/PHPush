<?php

namespace PHPush;

// Including some files
require_once 'autoload.php';
require_once 'Provider.php';

/**
 * Class PHPush
 *
 * @package PHPush
 */
class PHPush {

    /**
     * List of provider classes
     *
     * @var array
     */
    private static $providers = [];

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
     * Returns provider
     *
     * @param string $provider_name
     *
     * @return providers\Provider
     * @throws \Exception
     */
    public static function Provider($provider_name) {

        // Check if provider exists
        if (!self::provider_exists($provider_name)) throw new \Exception("Provider '{$provider_name}' does not exist.");

        // If provider's instance is not created yet
        if (empty(self::$providers[$provider_name])) {

            // Getting class name
            $class_name = "\\PHPush\\providers\\{$provider_name}\\Provider";

            // Saving instance
            self::$providers[$provider_name] = new $class_name;
        }

        // Returns provider's instance
        return self::$providers[$provider_name];
    }

    /**
     * Creates new Queue
     *
     * @return Queue
     */
    public static function Queue() {
        return new Queue();
    }
}
