<?php 

namespace App\Controllers\Back;

use App\Core\Controller;

class TestController extends Controller{

    public function indexTest(){
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