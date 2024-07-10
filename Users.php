<?php
class Users{
    private $dataFile = 'data/users.json';
    public function register($userName,$email, $password){
        if(!$this->validatePassword($password)){
            throw new Exception("* Password must contain 8 character");
        }
        $users = $this->getUsers();
        if(!isset($users[$email])){
            $users[$email] = [
                "username" => $userName,
                "password" => password_hash($password,PASSWORD_BCRYPT),
                "link" => $this->generateUniqueLink($userName),
            ];
            file_put_contents($this->dataFile, json_encode($users,JSON_PRETTY_PRINT));
        }
    }
    public function login($email, $password){
        $users = $this->getUsers();
       
    
        if(isset($users[$email]) && password_verify($password, $users[$email]['password'])){
            
           
            if (password_verify($password, $users[$email]['password'])) {
                echo "Password verification successful.<br>";
                return true;
            } else{
                echo "Failed.";
            }
            echo "Usr not Found.";
        }
        return false;
    }

    public function getUniqueLink($email){
        $users = $this->getUsers();
        return $users[$email]['link'];

    }
    public function generateUniqueLink($email){
        return 'localhost:3002'.'/'.'feedback_form.php?user=' . md5($email);
    }
    public function getUsers(){
        if(!file_exists($this->dataFile)){
            return [];
        }
        return json_decode(file_get_contents($this->dataFile),true);
    }
    public function validatePassword($password){
        if(strlen($password)<8){
            return false;
        }
        return true;
    }
}