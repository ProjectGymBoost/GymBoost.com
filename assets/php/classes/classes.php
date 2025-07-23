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
    public $filter;
    public $stateCondition;
    public $distinctYears = array();
    public $attendanceLabels = array();
    public $attendanceData = array();
    public $membershipLabels = array();
    public $membershipData = array();
    public $ageLabels = array();
    public $ageData = array();

    public function __construct()
    {
        $this->year = isset($_GET['year']) ? $_GET['year'] : date('Y');
        $this->filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $this->stateCondition = $this->filter === 'active' ? "AND users.state = 'Active'" : "";
    }

    public function loadDistinctYear()
    {
        $query = "SELECT DISTINCT YEAR(startDate) AS year FROM user_memberships ORDER BY year";
        $result = executeQuery($query);
        while ($row = mysqli_fetch_assoc($result)) {
            $this->distinctYears[] = $row['year'];
        }
    }

    public function loadYearDropdown()
    {
        if (!empty($this->distinctYears)) {
            $options = '';
            foreach ($this->distinctYears as $year) {
                $selected = ($year == $this->year) ? 'selected' : '';
                $options .= "<option value=\"$year\" $selected>$year</option>";
            }

            return '
                <form method="GET" class="d-inline">
                    <select name="year" class="form-select d-inline" style="width: auto; display: inline-block; border: 3px solid var(--primaryColor);" onchange="this.form.submit()">
                        ' . $options . '
                    </select>
                    <input type="hidden" name="filter" value="' . htmlspecialchars($this->filter) . '">
                </form>';
        } else {
            return '<span class="text-muted">No recorded years available</span>';
        }
    }

    public function loadFilterDropdown()
    {
        $options = '';
        $filterOptions = [
            'all' => 'All',
            'active' => 'Active'
        ];

        foreach ($filterOptions as $value => $label) {
            $selected = ($value == $this->filter) ? 'selected' : '';
            $options .= "<option value=\"$value\" $selected>$label</option>";
        }

        return '
            <form method="GET" class="d-inline">
                <select name="filter" class="form-select d-inline" style="width: auto; border: 3px solid var(--primaryColor);" onchange="this.form.submit()">
                    ' . $options . '
                </select>
                <input type="hidden" name="year" value="' . htmlspecialchars($this->year) . '">
            </form>';
    }

    public function loadAttendanceData()
    {
        $months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];

        $this->attendanceLabels = $months;
        $this->attendanceData = array_fill(0, 12, 0);

        $query = "SELECT MONTH(checkinDate) AS month, COUNT(*) AS total
                FROM attendances
                JOIN users ON attendances.userID = users.userID
                WHERE YEAR(checkinDate) = $this->year
                AND users.role = 'user'
                $this->stateCondition
                GROUP BY MONTH(checkinDate)";

        $result = executeQuery($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $index = $row['month'] - 1;
            $this->attendanceData[$index] = $row['total'];
        }
    }

    public function loadMembershipData()
    {
        if ($this->filter === 'active') {
            $query = "SELECT memberships.planType, COUNT(*) AS total
              FROM user_memberships
              JOIN memberships ON user_memberships.membershipID = memberships.membershipID
              JOIN users ON users.userID = user_memberships.userID
              INNER JOIN (
                  SELECT userID, MAX(userMembershipID) AS latestMembershipID
                  FROM user_memberships
                  GROUP BY userID
              ) AS latest ON latest.latestMembershipID = user_memberships.userMembershipID
              WHERE YEAR(user_memberships.startDate) = $this->year
              AND users.role = 'user'
              $this->stateCondition
              GROUP BY memberships.planType";
        } else {
            $query = "SELECT memberships.planType, COUNT(*) AS total
              FROM user_memberships
              JOIN memberships ON user_memberships.membershipID = memberships.membershipID
              JOIN users ON users.userID = user_memberships.userID
              WHERE YEAR(user_memberships.startDate) = $this->year
              AND users.role = 'user'
              GROUP BY memberships.planType";
        }

        $result = executeQuery($query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->membershipLabels[] = $row['planType'];
                $this->membershipData[] = $row['total'];
            }
        } else {
            $this->membershipLabels = ["No Data"];
            $this->membershipData = [0];
        }
    }

    public function loadAgeDistribution()
    {
        date_default_timezone_set('Asia/Manila');

        $this->ageLabels = ["Senior (60+)", "Middle-Aged Adult (40-59)", "Young Adults (20-39)", "Teenagers (13-19)"];
        $this->ageData = [0, 0, 0, 0];

        $query = "SELECT users.birthday
                FROM users
                JOIN user_memberships ON users.userID = user_memberships.userID
                WHERE users.birthday IS NOT NULL
                AND user_memberships.userMembershipID = (
                    SELECT MIN(userMembershipID)
                    FROM user_memberships AS earliest_membership
                    WHERE earliest_membership.userID = users.userID
                )
                AND YEAR(user_memberships.startDate) = $this->year
                AND users.role = 'user'
                $this->stateCondition";

        $result = executeQuery($query);
        $today = new DateTime();
        $matchedUsers = 0;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $birthdate = new DateTime($row['birthday']);
                $age = $birthdate->diff($today)->y;

                if ($age >= 60) {
                    $this->ageData[0]++;
                    $matchedUsers++;
                } elseif ($age >= 40) {
                    $this->ageData[1]++;
                    $matchedUsers++;
                } elseif ($age >= 20) {
                    $this->ageData[2]++;
                    $matchedUsers++;
                } elseif ($age >= 13) {
                    $this->ageData[3]++;
                    $matchedUsers++;
                }
            }

            if ($matchedUsers === 0) {
                $this->ageLabels = ["No Data"];
                $this->ageData = [0];
            }
        } else {
            $this->ageLabels = ["No Data"];
            $this->ageData = [0];
        }
    }

    // Getters
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
    public function getAgeLabels()
    {
        return $this->ageLabels;
    }
    public function getAgeData()
    {
        return $this->ageData;
    }
    public function getYear()
    {
        return $this->year;
    }
    public function getFilter()
    {
        return $this->filter;
    }
}
