<?php

namespace App\Controllers;

use \Core\View;

/*
 * Signup controller
 */
class Signup extends \Core\Controller {
    
    public function newAction() {

        View::renderTemplate('Signup/new.html');
    }
}