<?php

require "../../connection/connection.php";
require "../../models/Question.php";

header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
        exit;
    }

    $question = $data['question'];
    $answer = $data['answer'];

    $Question = new Question($conn);

    $Question->setQuestion($question);
    $Question->setAnswer($answer);

    if ($Question->save()) {
        echo json_encode(["success" => true, "question" => $Question->getQuestion(), "answer" => $Question->getAnswer()]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add question"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
