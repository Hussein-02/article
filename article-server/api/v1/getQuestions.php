<?php

require "../../connection/connection.php";
require "../../models/Question.php";

header("Content-Type: application/json");

$Question = new Question($conn);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $question = $Question->find($id);

        if ($questionData) {
            echo json_encode(["success" => true, "question" => $questionData]);
        } else {
            echo json_encode(["success" => false, "message" => "Question not found"]);
        }
    } else {
        $questions = $Question->all();
        if ($questions) {
            echo json_encode(["success" => true, "questions" => $questions]);
        } else {
            echo json_encode(["success" => false, "message" => "No questions found"]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
