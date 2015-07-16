<?php
/**
 * @package Aisconverse
 * @version 1.0
 */
/*
Plugin Name: Aisconverse
Description: Aisconverse test plugin
Author: Stanislav Shvaiko
Version: 1.0
*/
class Aisconverse_Plugin_Base
{
    public function __construct() {

    }
    static function install() {
        // Check for required PHP version
        if (version_compare(PHP_VERSION, '5.4', '<'))
        {
            exit(sprintf('Foo requires PHP 5.4 or higher. You’re still on %s.',PHP_VERSION));
        }
    }
}
register_activation_hook( __FILE__, array( 'Aisconverse_Plugin_Base', 'install' ) );
// Initialize everything
new Aisconverse_Plugin_Base();