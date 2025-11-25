<?php

namespace App\Models;

class User {
    public function all(): array {
        return [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
        ];
    }
}
