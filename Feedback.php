<?php
require_once 'Users.php';

class Feedback

{
    private $dataFile = 'data/feedbacks.json';
    public function saveFeedBack( $feedback, $userHash)
    {   
        $feedbacks = $this->getFeedbacks();

        $feedbacks[] = [
            'user' => $userHash,
            'feedback' => $feedback

        ];
        file_put_contents($this->dataFile,json_encode($feedbacks, JSON_PRETTY_PRINT));
    }

    public function getFeedbacksForUser($userHash)
    {
        $feedbacks = $this->getFeedbacks();
        return array_filter($feedbacks, function($feedback) use($userHash){
            return $feedback['user']===$userHash;
        });
    }
    public function getFeedbacks()
    {
        if(!file_exists($this->dataFile)){
            return [];
        }
        return json_decode(file_get_contents($this->dataFile),true);
    }
}