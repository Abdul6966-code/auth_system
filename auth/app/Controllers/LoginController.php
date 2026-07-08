<?php

namespace App\Controllers;

use App\Models\User;

class LoginController
{
    public function index()
    {

        // $user = new User;
        // $data = $user->fetchSingle('SELECT * FROM users where id =1');

        // echo '<pre>';
        // print_r($data);
        // exit;

        view('auth.login');
    }

    public function login()
    {

        if (empty($_POST['email']) || empty($_POST['password'])) {
            echo "All fields are required!";
            return;
        }

        $user = new User();
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];

        if ($user->login()) {

            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;

            redirect('dashboard');
            // header("Location: /dashboard");
            exit();
        } else {
            echo "Login failed!";
        }
    }
}
