<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

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

        $remember_me = isset($_POST['remember_me']);

        if ($user) {
            Auth::login($user, $remember_me);

            Flash::addMessage('Logowanie udane!');

            $this->redirect(Auth::getReturnToPage());
        } else {
            Flash::addMessage('Logowanie nieudane, proszę spróbuj ponownie', Flash::WARNING);
            
            View::renderTemplate('Home/index.html', [
                'username' => $_POST['username'],
                'remember_me' => $remember_me
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

        $this->redirect('/login/show-logout-message');
    }

    /*
     * Show a "logged out" flash message and redirect to the homepage. Necessary to use the flash messages
     * as they use the session and at the end of the logout method (destoryAction) the session is destroyed
     * so a new action needs to be called in orider to use the session.
     * 
     * @return void
     */
    public function showLogoutMessageAction() {
        Flash::addMessage('Wylogowanie udane!');

        $this->redirect('/');
    }



}