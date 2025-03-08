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

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
        exit;
    }

    $email = $data['email'];
    $password = $data['password'];

    $user = new User($conn);

    $existingUser = $user->findByEmail($email);

    if ($existingUser) {
        //check if password is correct
        if (hash('sha256', $password) === $existingUser->getPassword()) {
            $form = [
                "id" => $existingUser->getId(),
                "email" => $existingUser->getEmail(),
                "exp" => time() + 60 * 60
            ];

            $token = generate_jwt($form, $key);

            echo json_encode([
                "success" => true,
                "token" => $token,
                "user" => [
                    "id" => $existingUser->getId(),
                    "fullname" => $existingUser->getFullName(),
                    "email" => $existingUser->getEmail()
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect password"]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "Email not found"]);
        exit;
    }
}
