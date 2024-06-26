<?php

namespace Royl\WpThemeBase\Ajax;

use Royl\WpThemeBase\Util;

/**
 * Simple interface for handling ajax requests
 *
 * Usage: /wp-admin/admin-ajax.php?action=royl_ajax&c=CLASS&m=METHOD&_wpnonce=NONCE
 *
 * Params for ajax request:
 * c         = class to instantiate
 * m         = method to run
 * _wpnonce  = WordPress Nonce
 *
 *
 * @package     WpThemeBase
 * @subpackage  Core
 * @author      Roy Lindauer <hello@roylindauer.com>
 * @version     1.0
 */
class Ajax
{
    private $ajaxClassNamespace = '\Royl\WpThemeBase\Ajax\Response';

    /**
     * Setup the Ajax handler
     */
    public function __construct()
    {
        add_action('wp_ajax_royl_ajax', [&$this, 'execute']);
        add_action('wp_ajax_nopriv_royl_ajax', [&$this, 'execute']);
        $this->setClassNamespace();
    }
    
    /**
     * Set the custom namespace
     */
    public function setClassNamespace()
    {
        $customNamespace = Util\Configure::read('ajax.namespace');
        if ($customNamespace) {
            $this->ajaxClassNamespace = $customNamespace;
        }
    }
    
    /**
     * Handles the ajax request
     */
    public function execute()
    {
        try {
            // Expect a valid wp nonce
            if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'royl_execute_ajax_nonce')) {
                throw new \Exception('Invalid ajax request');
            }
 
            // Make sure we have a class and a method to execute
            if (!isset($_REQUEST['c']) && !isset($_REQUEST['m'])) {
                throw new \Exception('Invalid params in ajax request');
            }
 
            // define class
            $c = filter_var($_REQUEST['c'], FILTER_SANITIZE_STRING);
            $class = "{$this->ajaxClassNamespace}\\$c";
 
            if (!class_exists($class)) {
                throw new \Exception(sprintf('Class %s does not exist', $class));
            }
 
            // Instantiate new Ajax Response object
            $AjaxResponse = new $class();
 
            // Get the requested method
            $ajaxMethod = filter_var($_REQUEST['m'], FILTER_SANITIZE_STRING);
 
            // Execute method
            $AjaxResponse->execute($ajaxMethod);
        } catch (\Exception $e) {
            Util\Debug::log( $e->getMessage() );
            wp_die($e->getMessage());
        }
        die();
    }
}
