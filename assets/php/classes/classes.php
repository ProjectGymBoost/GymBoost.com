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

class ChartData
{
    public $year;
    public $distinctYears = array();
    public $attendanceLabels = array();
    public $attendanceData = array();
    public $membershipLabels = array();
    public $membershipData = array();

    public function __construct()
    {
        $this->year = isset($_GET['year']) ? $_GET['year'] : date('Y');
    }

    public function loadDistinctYear()
    {
        $query = "SELECT DISTINCT YEAR(checkinDate) AS year FROM attendances ORDER BY year";
        $result = executeQuery($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $this->distinctYears[] = $row['year'];
        }
    }

    public function loadYearDropdown()
    {
        $options = '';

        if (!empty($this->distinctYears)) {
            foreach ($this->distinctYears as $year) {
                $options .= '
                    <li>
                        <a class="dropdown-item" href="?year=' . $year . '">' . $year . '</a>
                    </li>';
            }
        } else {
            $options = '
                <li><a class="dropdown-item text-muted">No recorded years available</a></li>';
        }

        return '
            <button type="button" class="btn btn-primary dropdown-toggle" style="border-radius: 2px" data-bs-toggle="dropdown" aria-expanded="false">
                YEAR
            </button>
            <ul class="dropdown-menu">
                ' . $options . '
            </ul>';
    }

    public function loadAttendanceData()
    {
        $months = ["January", "February", "March", "April", "May", "June",
           "July", "August", "September", "October", "November", "December"];

        $this->attendanceLabels = $months;
        $this->attendanceData = array_fill(0, 12, 0);

        $query = "SELECT MONTH(checkinDate) AS month, COUNT(*) AS total
                  FROM attendances
                  WHERE YEAR(checkinDate) = $this->year
                  GROUP BY MONTH(checkinDate)";
        $result = executeQuery($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $index = $row['month'] - 1;
            $this->attendanceData[$index] = $row['total'];
        }
    }

    public function loadMembershipData()
    {
        $query = "SELECT memberships.planType, COUNT(*) AS total
                  FROM user_memberships
                  JOIN memberships ON user_memberships.membershipID = memberships.membershipID
                  WHERE YEAR(user_memberships.startDate) = $this->year
                  GROUP BY memberships.planType";
        $result = executeQuery($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $this->membershipLabels[] = $row['planType'];
            $this->membershipData[] = $row['total'];
        }
    }

    public function getAttendanceLabels()
    {
        return $this->attendanceLabels;
    }

    public function getAttendanceData()
    {
        return $this->attendanceData;
    }

    public function getMembershipLabels()
    {
        return $this->membershipLabels;
    }

    public function getMembershipData()
    {
        return $this->membershipData;
    }

    public function getYear()
    {
        return $this->year;
    }
}
?>