<?php
require_once('database/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userData = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'age' => $_POST['age'],
        'profile' => $_POST['image_url']
    ];
    createStudent($userData);
}
header('Location: index.php');