<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Auth;

class DashboardController extends View
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth();
        if (!$this->auth->isLoggedIn()) {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $user = $this->auth->getCurrentUser();
        $this->render('dashboard/index', [
            'user' => $user,
            'permissions' => $user->getAllPermissions()
        ]);
    }
}
