<?php

namespace App\Models;

use PDO;

/*
 * Example user model
 */

 class User extends \Core\Model {

    /*
     * Error messages
     * 
     * @var array
     */
    public $errors = [];
    
    /*
     * Class constructor
     * 
     * @param array $data   Initial property values
     * @return void
     */
    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /*
     * Save the user model with the current property value
     * 
     * @return void
     */
    public function save() {
        
        $this->validate();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (username, password, email)
                    VALUES (:username, :password_hash, :email)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    /*
     * Validate current property values, adding validation error messages to the errors array property
     * 
     * @return void
     */
    public function validate() {
        
        // Name
        if ($this->username == '') {
            $this->errors[] = 'Name is required';
        }

        if (static::loginExists($this->username)) {
            $this->errors = 'Login already taken';
        } 

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }

        if (static::emailExists($this->email)) {
            $this->errors = 'Email already taken';
        }

        // Password
        /*if ($this->password != $this->password_confirmation) {
            $this->errors[] = 'Password must match confirmation';
        } */

        if ((strlen($this->password) < 8) || (strlen($this->password) > 20)) {
            $this->errors[] = 'Password must have from 8 to 20 characters';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one letter';
        }

        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one number';
        }
    }

     /*
     * See if a user record already exists with the specified login
     * 
     * @param string $login username to search for
     * 
     * @return boolean  True if a record already exists with the specified login, false otherwise
     */
    public static function loginExists($username) {
        return static::findByUsername($username) != false;
    }
    
    /*
     * See if a user record already exists with the specified email
     * 
     * @param string $email email adress to search for
     * 
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    public static function emailExists($email) {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    /*
     * Find a user model by username
     * 
     * @param string $username username to search for
     * 
     * @return mixed    User object if found, false otherwise
     */
    public static function findByUsername($username) {
        $sql = 'SELECT * FROM users WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /*
     * Authenticate a user by username and password
     * 
     * @param string $username username
     * @param string @password password
     * 
     * @return mixed    The user object or false if authentication fails
     */
    public static function authenticate($username, $password) {
        $user = static::findByUsername($username);

        if($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    /*
     * Find a user model by ID
     * 
     * @param string $id    The user ID
     * 
     * @return mixed    User object if found, false otherwise
     */
    public static function findByID($id) {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }
 }