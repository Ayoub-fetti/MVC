<?php 
namespace App\Controllers\Back;
use App\Core\Controller;
use App\Models\User;

class TestController extends Controller {

    public function indexTest(){
        // $user = User::find(1);
        // var_dump($user);
        echo "Test Controller - IndexTest Action"; 
    }

    public function hello(){
        echo "Hello from Test Controller!";
    }

    public function params(){
        echo "Testing route parameters:<br>";
        echo "<pre>";
        print_r($_GET);
        echo "</pre>";
    }

}