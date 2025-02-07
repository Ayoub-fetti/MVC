<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Auth;
use App\Models\User;

class AuthController extends View
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function login()
    {
       
            $this->render('auth/login');
      
    }
    public function register()
    {
       
            $this->render('auth/register');
      
    }


    // public function handllogin()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    //         $email = $_POST['email'] ?? '';
    //         $password = $_POST['password'] ?? '';

    //         if ($this->auth->login($email, $password)) {
    //             $user = $this->auth->getCurrentUser();
    //             if ($user->role === 'admin') {
    //                 $this->redirect('admin/dashboard');
    //             } else {
    //                 $this->redirect('dashboard');
    //             }
    //         } else {
    //             $this->render('auth/login', [
    //                 'errors' => ['login' => 'Invalid credentials'],
    //                 'email' => $email
    //             ]);
    //         }
    //     } else {
    //         $this->render('auth/login');
    //     }
    // }
    public function handllogin(){
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = $this->auth->login($email, $password);

        if ($result['success']) {
            $user = $this->auth->getCurrentUser();
            if ($user->role === 'admin') {
                $this->redirect('admin/dashboard');
            } else {
                $this->redirect('dashboard');
            }
        } else {
            $this->render('auth/login', [
                'errors' => $result['errors'],
                'email' => $email
            ]);
        }
    } else {
        $this->render('auth/login');
    }
}
    public function handlregister()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'password_confirmation' => $_POST['password_confirmation'] ?? ''
            ];

            $validator = new \App\Core\Validator($data);
            $rules = [
                'username' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'password_confirmation' => 'required|match:password'
            ];

            if ($validator->validate($rules)) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $data['role'] = 'user'; // Default role

                if (User::create($data)) {
                    $this->redirect('/login');
                } else {
                    $this->render('auth/register', [
                        'error' => 'Registration failed',
                        'data' => $data
                    ]);
                }
            } else {
                $this->render('auth/register', [
                    'errors' => $validator->errors,
                    'data' => $data
                ]);
            }
        } else {
            $this->render('auth/register');
        }
    }

    public function logout()
    {
        $this->auth->logout();
        $this->redirect('/login');
    }
}
