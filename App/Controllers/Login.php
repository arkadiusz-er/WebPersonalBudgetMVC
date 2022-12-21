<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;

/*
 * Login controller
 */

class Login extends \Core\Controller {

    /*
     * Show the login page
     * 
     * @return void
     */
    public function newAction() {
        View::renderTemplate('Home/index.html', [
            'message' => $_GET['message']
        ]);
    }

    /*
     * Log in a user
     * 
     * @return void
     */
    public function createAction() {
        $user = User::authenticate($_POST['username'], $_POST['password']);

        if ($user) {
            Auth::login($user);

            $this->redirect(Auth::getReturnToPage());
        } else {
            View::renderTemplate('Home/index.html', [
                'username' => $_POST['username'],
            ]);
        }
    }

    /*
     * Log out a user
     * 
     * @return void
     */
    public function destroyAction() {
        Auth::logout();

        $this->redirect('/');
    }



}