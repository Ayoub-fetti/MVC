<?php 

namespace App\Controllers\Back;

use App\Core\Controller;

class TestController extends Controller{

    public function index(){
        echo "Test Controller - Index Action"; 
    }

    public function hello($name = 'world'){
        echo "Hello, {$name}!";
    }

    public function params(){
        echo "Testing route parameters:<br>";
        echo "<pre>";
        print_r($_GET);
        echo "</pre>";
    }

}