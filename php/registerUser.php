<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? null;
    $username = $_POST["username"] ?? null;
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;
    $gender = $_POST["gender"] ?? null;

    if (!$name || !$username || !$email || !$password || !$gender) {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
        exit;
    }


    $file = "../data/users.json";
    $users = [];
    if (file_exists($file)) {
        $users = json_decode(file_get_contents($file), true);
    }

    foreach ($users as $user) {
        if ($user["username"] === $username) {
            echo json_encode(["status" => "error", "message" => "Username already exists"]);
            exit;
        }
    }

    $users[] = [
        "name" => $name,
        "username" => $username,
        "email" => $email,
        "password" => $password, 
        "gender" => $gender
    ];

    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
