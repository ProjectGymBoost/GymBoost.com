<?php
class User
{
    public $userID;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $rfid;
    public $birthday;

    public function __construct($userID, $firstName, $lastName, $email, $password, $rfid, $birthday)
    {
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->rfid = $rfid;
        $this->birthday = $birthday;
    }

    public function RegisterUser($membershipID, $startDate, $endDate)
    {
        global $conn;
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

        // Insert user into users table
        $insertUserQuery = "INSERT INTO users (firstName, lastName, birthday, email, password, rfidNumber) 
                            VALUES ('$this->firstName', '$this->lastName', '$this->birthday', '$this->email', '$passwordHash', '$this->rfid')";
        $userResult = executeQuery($insertUserQuery);

        if ($userResult) {
            $userID = mysqli_insert_id($conn);

            $insertMemberQuery = "INSERT INTO user_memberships (userID, membershipID, startDate, endDate) 
                                  VALUES ('$userID', '$membershipID', '$startDate', '$endDate')";
            return executeQuery($insertMemberQuery);
        }
        return false;
    }
}

?>
