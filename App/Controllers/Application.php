<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
/*
 * Main application
 */

 class Application extends Authenticated {
    
    /*
     * Application index
     * 
     * @return void
     */
    public function indexAction() {
        View::renderTemplate('Application/index.html');
    }

    /*
     * Test
     */
    public function newAction() {
        echo "new action";
    }

    /*
     * Test2
     */
    public function showAction() {
        echo "show action";
    }

 }