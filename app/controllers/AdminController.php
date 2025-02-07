<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Auth;
use App\Models\User;
use App\Models\Permission;

class AdminController extends View
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth();
        if (!$this->auth->isLoggedIn() || !$this->auth->getCurrentUser()->role === 'admin') {
            $this->redirect('/login');
        }
    }

    public function dashboard()
    {
        $users = User::all();
        $permissions = Permission::all();
        
        $this->render('admin/dashboard', [
            'users' => $users,
            'permissions' => $permissions,
            'currentUser' => $this->auth->getCurrentUser()
        ]);
    }

    public function users()
    {
        if (!$this->auth->hasPermission('manage_users')) {
            $this->redirect('/admin/dashboard');
        }

        $users = User::all();
        $this->render('admin/users', [
            'users' => $users
        ]);
    }

    public function permissions()
    {
        if (!$this->auth->hasPermission('manage_permissions')) {
            $this->redirect('/admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $permissionId = $_POST['permission_id'] ?? null;
            $action = $_POST['action'] ?? '';

            $user = User::find($userId);
            if ($user && $action === 'grant') {
                // Logic to grant permission
            } elseif ($user && $action === 'revoke') {
                // Logic to revoke permission
            }
        }

        $permissions = Permission::all();
        $users = User::all();
        
        $this->render('admin/permissions', [
            'permissions' => $permissions,
            'users' => $users
        ]);
    }
}
