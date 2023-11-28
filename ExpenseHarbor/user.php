<?php
    class User extends Base{
        function __construct($pdo)
        {
            $this->pdo = $pdo;
        }   

        // Removes extra space and html code from input
        public function checkInput($var)
        {
            $var = htmlspecialchars($var);
            $var = trim($var);
            $var = stripslashes($var);
            return $var;
        }

         // Sets the reset token and expiry time for a user
    public function setResetToken($userId, $resetToken, $expiryTime) {
        $stmt = $this->pdo->prepare("UPDATE user SET ResetToken = :resetToken, ExpiryTime = :expiryTime WHERE UserId = :userId");
        $stmt->bindParam(":resetToken", $resetToken, PDO::PARAM_STR);
        $stmt->bindParam(":expiryTime", $expiryTime, PDO::PARAM_STR);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();
    }


        //

        public function getUserByEmailOrUsername($emailOrUsername) {
            // Implement the logic to fetch the user from the database based on email or username
            // Perform the necessary database query and return the user data or false if not found
            // Example: (this is a simplified example, replace it with your actual database query)
        
            // Placeholder comment - replace this with your actual database query execution
            $stmt = $this->pdo->prepare("SELECT * FROM `user` WHERE `Email` = :email OR `Username` = :username");
            $stmt->bindParam(":email", $emailOrUsername, PDO::PARAM_STR);
            $stmt->bindParam(":username", $emailOrUsername, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
        
            if ($result) {
                return $result; // Return the user object or data
            } else {
                return false; // User not found
            }
        }
        
        
    
        // Logs a user in
        public function login($username, $password) 
        {
            $stmt = $this->pdo->prepare("SELECT UserId FROM user WHERE Username = :username AND Password = :password");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $hash = md5($password);
            $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            
            if($count>0)
            {

                $_SESSION['UserId'] = $user->UserId;
                header("Location: templates/3-Dashboard.php");
            }
            else
            {
                return false;
            }
        }

        // Checks if email already exists
        public function checkEmail($email)
        {
            $stmt = $this->pdo->prepare("SELECT UserId FROM user WHERE Email = :email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if($count>0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        // Checks if username already exists
        public function checkUsername($username)
        {
            $stmt = $this->pdo->prepare("SELECT UserId FROM user WHERE Username = :username");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if($count>0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        // Returns the path of profile picture from database by user id
        public function Photofetch($UserId) {
            $stmt = $this->pdo->prepare("SELECT Photo FROM user WHERE UserId = :UserId");
            $stmt->bindParam(":UserId", $UserId, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user->Photo;
        }

        
        // Logs a user out
        public function logout()
        {
            session_destroy();
            header("Location: ". BASE_URL .'index.php');
        }

        // Checks if a user is logged in
        public function loggedIn() 
        {
            if (isset($_SESSION['UserId'])) {
              return true;
            } 
            return false;
        }

        // Returns a user's entire data
        public function userData($user_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE UserId = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>