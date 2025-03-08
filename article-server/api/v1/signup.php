<?php

include "../../connection/connection.php";
include "../../models/User.php";

$key = "12345";

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function generate_jwt($payload, $key)
{
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $header_encoded = base64url_encode($header);

    $payload_encoded = base64url_encode(json_encode($payload));

    $signature = hash_hmac('sha256', "$header_encoded.$payload_encoded", $key, true);
    $signature_encoded = base64url_encode($signature);

    return "$header_encoded.$payload_encoded.$signature_encoded";
}

$usermodel = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data || !isset($data['fullname']) || !isset($data['email']) || !isset($data['password'])) {
        echo json_encode(["success" => false, "message" => "Invalid input: fullname, email, and password are required"]);
        exit;
    }

    $fullname = $data['fullname'];
    $email = $data['email'];
    $password = $data['password'];

    $user = new User($conn);

    $existingUser = $user->findByEmail($email);
    if ($existingUser) {
        echo json_encode(["success" => false, "message" => "Email already registered"]);
        exit;
    }

    $user->setFullName($fullname);
    $user->setEmail($email);
    $user->setPassword($password);

    if ($user->save()) {
        echo json_encode(["success" => true, "message" => "User registered successfully", "user" => [
            "id" => $user->getId(),
            "fullname" => $user->getFullName(),
            "email" => $user->getEmail()
        ]]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to register user"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
