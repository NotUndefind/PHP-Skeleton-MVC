<?php


namespace App\Controllers;

use App\Models\User;

class HomeController {
    public function index() {
        $users = new User();
        $users = $users->all();

        echo '<pre>';
        print_r($users);
        echo '</pre>';
        require __DIR__ . '/../views/home.php';
    }
}
