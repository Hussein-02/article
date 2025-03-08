<?php

class QuestionSkeleton
{

    private $id;
    private $question;
    private $answer;

    public function __construct($id = null, $question = null, $answer = null)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
    }

    //getters/setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function setQuestion($question)
    {
        $this->question = $question;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    //crud methods to be implemented in model
    public function save()
    {
        //implement
    }

    public function find($id)
    {
        //implement
    }

    public function all()
    {
        //implement
    }

    public function delete()
    {
        //implement
    }
}
