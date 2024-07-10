<?php
class Helpers{
    public function sanitize(string $data):string{
        return htmlspecialchars(stripcslashes(trim($data)));
    }
    public function flash($key, $message=""){
        //If message are passed in, then the message set to session.
        if($message){
            $_SESSION['flash'][$key] = $message;
        // If message has not been passed in, plz delete the session message.
        }else if(isset($_SESSION['flash'][$key])){
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        
    }
    public function validateEmail(string $email):string
    {
        $validatedEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        
        return $validatedEmail;
    }

    public function validateInputs($data)
    {
        if(empty($data)){
            $message = "<p style='color:red;'>* Field must not be blank. </p>";
            return $message;
        }
        
    }
}