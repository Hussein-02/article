<?php

require "../../connection/connection.php";
require "../../models/Question.php";

header("Content-Type: application/json");

$Question = new Question($conn);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $question = $Question->find($id);

        if ($question) {
            echo json_encode(["success" => true, "question" => $question->getQuestion(), "answer" => $question->getAnswer()]);
        } else {
            echo json_encode(["success" => false, "message" => "Question not found"]);
        }
    } else {
        $questions = $Question->all();
        if ($questions) {
            $QuestionsList = [];
            foreach ($questions as $question) {
                $QuestionsList[] = [
                    "question" => $question->getQuestion(),
                    "answer" => $question->getAnswer()
                ];
            }

            echo json_encode([
                "success" => true,
                "questions" => $QuestionsList
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "No questions found"]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
