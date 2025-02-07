<?php 
namespace App\Controllers\Back;
use App\Core\Controller;
use App\Models\User;

class TestController extends Controller {

    public function indexTest(){
        $user = User::find(1);
        var_dump($user);
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

    public function testCreate() {
        // Test de creation d'un utilisateur using Eloquent
        $user = User::create([
            'username' => 'ayoub',
            'email' => 'ayoub@gmail.com',
            'password' => '123456'
        ]);
        
        echo "<h2>Test pour creer un user</h2>";
        echo "ID: " . $user->id . "<br>";
        echo "Name: " . $user->username . "<br>";
        echo "Email: " . $user->email . "<br>";
        echo "Date création: " . $user->created_at . "<br>";
        
        return $user;
    }

    public function testRead($id = null) {
        // Test de lecture d'un utilisateur using Eloquent
        if ($id === null) {
            $user = $this->testCreate(); // Create a test user if no ID provided
        } else {
            $user = User::find($id);
            if (!$user) {
                echo "User not found!";
                return;
            }
        }

        echo "<h2>Test pour lire un user</h2>";
        echo "ID: " . $user->id . "<br>";
        echo "Name: " . $user->username . "<br>";
        echo "Email: " . $user->email . "<br>";
    }

    public function testUpdate() {
        // Test de mise à jour d'un utilisateur using Eloquent
        $user = $this->testCreate();
        
        echo "<h2>Test pour update un user</h2>";
        echo "before:<br>";
        echo "Name: " . $user->username . "<br>";
        
        $user->username = 'Ayoub Oumha';
        $user->save();
        
        echo "after:<br>";
        echo "Name: " . $user->username . "<br>";
    }

    public function testDelete() {
        // Test de suppression d'un utilisateur using Eloquent
        $user = $this->testCreate();
        
        echo "<h2>Test pour supprimer user</h2>";
        echo "ID: " . $user->id . "<br>";
        echo "Suppression en cours...<br>";
        
        $user->delete();
        
        echo "Utilisateur supprimé avec succès";
    }

    public function testAll() {
        echo "<h1>Tests CRUD Utilisateur</h1>";
        
        // Execute all tests
        echo "<div style='margin: 20px; padding: 20px; border: 1px solid #ccc;'>";
        $this->testCreate();
        echo "</div>";
        
        echo "<div style='margin: 20px; padding: 20px; border: 1px solid #ccc;'>";
        $this->testRead();
        echo "</div>";
        
        echo "<div style='margin: 20px; padding: 20px; border: 1px solid #ccc;'>";
        $this->testUpdate();
        echo "</div>";
        
        echo "<div style='margin: 20px; padding: 20px; border: 1px solid #ccc;'>";
        $this->testDelete();
        echo "</div>";
    }
}