<?php

class User
{
    public $userID;
    public $firstName;
    public $lastName;
    public $email;
    public $password;

    public function __construct($userID, $firstName, $lastName, $email, $password)
    {
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function RegisterUser($membershipID, $startDate, $endDate)
    {
        global $conn;
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

        // Insert user into users table
        $insertUserQuery = "INSERT INTO users (firstName, lastName, email, password) 
                            VALUES ('$this->firstName', '$this->lastName', '$this->email', '$passwordHash')";
        $userResult = executeQuery($insertUserQuery);

        // Check if user insertion was successful
        if ($userResult) {
            $userID = mysqli_insert_id($conn);

            // If successful, insert into user_memberships table
            $insertMemberQuery = "INSERT INTO user_memberships (userID, membershipID, startDate, endDate) 
                                  VALUES ('$userID', '$membershipID', '$startDate', '$endDate')";
            return executeQuery($insertMemberQuery);
        }
        return false;
    }
}
?>
