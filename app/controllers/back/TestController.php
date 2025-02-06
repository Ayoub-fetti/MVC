<?php 

namespace App\Controllers\Back;

use App\Core\Controller;
use App\Models\User;

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

    public function testCreate() {
        // Test de creation d'un utilisateur
        $user = new User(1, 'ayoub', 'ayoub@gmail.com', '123456', date('Y-m-d H:i:s'));
        
        echo "<h2>Test bach ncreer un user</h2>";
        echo "ID: " . $user->getId() . "<br>";
        echo "Smiya: " . $user->getUsername() . "<br>";
        echo "Email: " . $user->getEmail() . "<br>";
        echo "Password: " . $user->getPassword() . "<br>";
        echo "Date création: " . $user->getCreatedAt() . "<br>";
        
        return $user;
    }

    public function testRead($id = null) {
        // Test de lecture d'un utilisateur
        if ($id === null) {
            $user = $this->testCreate(); // Creer un utilisateur de test si aucun ID n'est fourni
        } else {
            $user = new User($id, 'test_user', 'test@example.com', 'test123', date('Y-m-d H:i:s'));
        }

        echo "<h2>Test bach jbed un user</h2>";
        echo "ID: " . $user->getId() . "<br>";
        echo "Smiya: " . $user->getUsername() . "<br>";
        echo "Email: " . $user->getEmail() . "<br>";
    }

    public function testUpdate() {
        // Test de mise à jour d'un utilisateur
        $user = $this->testCreate();
        
        echo "<h2>Test bach update un user</h2>";
        echo "before:<br>";
        echo "Smiya: " . $user->getUsername() . "<br>";
        
        $user->setUsername('Ayoub Oumha');
        
        echo "after:<br>";
        echo "Smiya: " . $user->getUsername() . "<br>";
    }

    public function testDelete() {
        // Test de suppression d'un utilisateur
        $user = $this->testCreate();
        
        echo "<h2>Test bach namse7 user</h2>";
        echo "ID dyal khona: " . $user->getId() . "<br>";
        echo "Tsna chwiya ...<br>";
        echo "Safi rah msa7t khona";
    }

    public function testAll() {
        echo "<h1>Tests CRUD Utilisateur</h1>";
        
        // Executer tous les tests
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