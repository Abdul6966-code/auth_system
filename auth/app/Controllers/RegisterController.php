<?php

namespace App\Controllers;

use App\Models\User;

class RegisterController
{
    public function index()
    {
        view('auth.register');
    }


    public function register()
    {
        // Process registration logic here
        $user = new User;
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];

        if ($user->register()) {
            // Registration successful
            echo "Registration successful!";
        } else {
            // Registration failed
            echo "Registration failed!";
        }
    }
}
