<?php

require "./QuestionSkeleton.php";
require "../connection/connection.php";

class Question extends QuestionSkeleton
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function save()
    {
        $question = $this->getQuestion();
        $answer = $this->getAnswer();
        $id = $this->getId();

        if ($id) {
            $sql = "UPDATE questions SET question = ?, answer = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $question, $answer, $id);
            $stmt->execute();
        } else {
            $sql = "INSERT INTO questions (question, answer) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $question, $answer);
            $stmt->execute();

            $this->setId($this->conn->insert_id);
        }
    }

    public function find($id)
    {
        $sql = "SELECT * FROM questions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            return new Question($row['id'], $row['question'], $row['answer']);
        }
        return null;
    }

    public function all()
    {
        $sql = "SELECT * FROM questions";
        $result = $this->conn->query($sql);
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = new Question($row['id'], $row['question'], $row['answer']);
        }
        return $questions;
    }

    public function delete()
    {
        $id = $this->getId();
        $sql = "DELETE FROM questions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
