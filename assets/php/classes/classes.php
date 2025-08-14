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

    public function RegisterUser($role, $membershipID = null, $startDate = null, $endDate = null)
    {
        global $conn;
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

        if ($role === "admin") {
            $insertUserQuery = "INSERT INTO users (firstName, lastName, birthday, email, password, role) 
                        VALUES ('$this->firstName', '$this->lastName', '$this->birthday', '$this->email', '$passwordHash', '$role')";
        } else {
            $insertUserQuery = "INSERT INTO users (firstName, lastName, birthday, email, password, rfidNumber, role) 
                        VALUES ('$this->firstName', '$this->lastName', '$this->birthday', '$this->email', '$passwordHash', '$this->rfid', '$role')";
        }

        $userResult = executeQuery($insertUserQuery);

        if ($userResult) {
            $userID = mysqli_insert_id($conn);

            // Insert membership only for regular users
            if ($role === "user" && $membershipID && $startDate && $endDate) {
                $insertMemberQuery = "INSERT INTO user_memberships (userID, membershipID, startDate, endDate) 
                              VALUES ('$userID', '$membershipID', '$startDate', '$endDate')";
                $membershipResult = executeQuery($insertMemberQuery);

                if (!$membershipResult) {
                    return false;
                }
            }

            // ✅ Set session flags correctly
            $_SESSION['userCreated'] = true;
            $_SESSION['createdUserRole'] = $role;

            return true;
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

        $allLabels = ["Seniors (60+)", "Middle-Aged Adults (40-59)", "Young Adults (20-39)", "Teenagers (13-19)"];
        $allData = [0, 0, 0, 0];

        $query = "SELECT users.birthday
            FROM users
            JOIN user_memberships ON users.userID = user_memberships.userID
            WHERE users.birthday IS NOT NULL
                AND users.role = 'user'
                $this->stateCondition
                AND user_memberships.userMembershipID = (
                    SELECT MIN(earliest_yearly_record.userMembershipID)
                    FROM user_memberships AS earliest_yearly_record
                    WHERE earliest_yearly_record.userID = users.userID
                    AND YEAR(earliest_yearly_record.startDate) = YEAR(user_memberships.startDate)
                )
                AND YEAR(user_memberships.startDate) = $this->year";

        $result = executeQuery($query);
        $today = new DateTime();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $birthdate = new DateTime($row['birthday']);
                $age = $birthdate->diff($today)->y;

                if ($age >= 60) {
                    $allData[0]++;
                } elseif ($age >= 40) {
                    $allData[1]++;
                } elseif ($age >= 20) {
                    $allData[2]++;
                } elseif ($age >= 13) {
                    $allData[3]++;
                }
            }

            // Filter only the labels with non-zero values
            $filteredLabels = [];
            $filteredData = [];

            for ($i = 0; $i < count($allData); $i++) {
                if ($allData[$i] > 0) {
                    $filteredLabels[] = $allLabels[$i];
                    $filteredData[] = $allData[$i];
                }
            }

            if (empty($filteredLabels)) {
                $this->ageLabels = ["No Data"];
                $this->ageData = [0];
            } else {
                $this->ageLabels = $filteredLabels;
                $this->ageData = $filteredData;
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

class WorkoutCalendar
{
    public $events = [];

    public function loadEvents($userID)
    {
        // DISPLAY WORKOUTS
        $query = "SELECT * FROM workout_logs WHERE userID = '$userID'";
        $result = executeQuery($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $this->events[] = [
                'id' => $row['workoutID'],
                'title' => $row['workoutType'],
                'start' => $row['startDate'],
                'end' => $row['endDate'],
                'color' => $row['color']
            ];
        }
    }

    public function getEvents()
    {
        return json_encode($this->events);
    }

    public function handleWorkoutActions($userID)
    {
        // ADD WORKOUT
        if (isset($_POST['addWorkout'])) {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $color = $_POST['color'];
            $workoutType = isset($_POST['workoutType'])
                ? (is_array($_POST['workoutType']) ? implode(', ', $_POST['workoutType']) : $_POST['workoutType'])
                : '';

            $query = "INSERT INTO workout_logs (userID, workoutType, startDate, endDate, color) 
                  VALUES ('$userID', '$workoutType', '$startDate', '$endDate', '$color')";
            executeQuery($query);

            $GLOBALS['showAddModal'] = true;
            $this->preventFormResubmission();
        }

        // EDIT WORKOUT
        if (isset($_POST['editWorkout'])) {
            $workoutID = $_POST['editWorkoutID'];
            $workoutType = isset($_POST['editWorkoutType'])
                ? (is_array($_POST['editWorkoutType']) ? implode(', ', $_POST['editWorkoutType']) : $_POST['editWorkoutType'])
                : '';
            $startDate = $_POST['editWorkoutStart'];
            $endDate = $_POST['editWorkoutEnd'];
            $color = $_POST['editWorkoutColor'];

            $query = "UPDATE workout_logs 
                  SET workoutType = '$workoutType', startDate = '$startDate', endDate = '$endDate', color = '$color'
                  WHERE workoutID = '$workoutID' AND userID = '$userID'";
            executeQuery($query);

            $GLOBALS['showEditModal'] = true;
            $this->preventFormResubmission();
        }

        // DELETE WORKOUT
        if (isset($_POST['deleteWorkout'])) {
            $workoutID = $_POST['deleteWorkoutID'];
            $query = "DELETE FROM workout_logs WHERE workoutID = '$workoutID' AND userID = '$userID'";
            executeQuery($query);

            $GLOBALS['showDeleteModal'] = true;
            $this->preventFormResubmission();
        }
    }

    public function preventFormResubmission()
    {
        echo <<<SCRIPT
        <script>
            if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
            }
        </script>
        SCRIPT;
    }

    public function formatWorkoutList($workouts)
    {
        $count = count($workouts);
        if ($count === 0)
            return '';
        if ($count === 1)
            return strtolower($workouts[0]);
        if ($count === 2)
            return strtolower($workouts[0] . ' and ' . $workouts[1]);
        return strtolower(implode(', ', array_slice($workouts, 0, -1)) . ' and ' . end($workouts));
    }
}

class UserChartData
{
    public $userID, $year;
    public $typeLabels = [], $typeCounts = [];
    public $monthlyLabels = [], $monthlyCounts = [];
    public $availableYears = [];

    public function __construct($userID, $year = null)
    {
        $this->userID = $userID;
        $this->year = $year ?? date('Y');
        $this->monthlyLabels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $this->monthlyCounts = array_fill(0, 12, 0);
    }

    public function loadWorkoutTypeData()
    {
        global $conn;
        $query = "SELECT workoutType FROM workout_logs
                WHERE userID = '$this->userID' AND YEAR(startDate) = '$this->year'";
        $result = executeQuery($query);

        $typeCounter = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $types = array_map('trim', explode(',', $row['workoutType']));
            foreach ($types as $type) {
                if (!empty($type)) {
                    $typeCounter[$type] = ($typeCounter[$type] ?? 0) + 1;
                }
            }
        }

        if (!empty($typeCounter)) {
            foreach ($typeCounter as $type => $count) {
                $this->typeLabels[] = $type;
                $this->typeCounts[] = $count;
            }
        } else {
            $this->typeLabels = ["No Data"];
            $this->typeCounts = [0];
        }
    }


    public function loadMonthlyWorkoutData()
    {
        global $conn;
        $query = "SELECT MONTH(startDate) AS month, COUNT(*) AS count
          FROM workout_logs
          WHERE userID = '$this->userID' AND YEAR(startDate) = '$this->year'
          GROUP BY MONTH(startDate)";
        $result = executeQuery($query);
        while ($row = mysqli_fetch_assoc($result)) {
            $this->monthlyCounts[$row['month'] - 1] = intval($row['count']);
        }
    }

    public function loadAvailableYears()
    {
        global $conn;
        $query = "SELECT DISTINCT YEAR(startDate) AS year
          FROM workout_logs
          WHERE userID = '$this->userID'
          ORDER BY year DESC";
        $result = executeQuery($query);
        while ($row = mysqli_fetch_assoc($result)) {
            $this->availableYears[] = $row['year'];
        }
    }

    public function loadYearDropdown()
    {
        if (empty($this->availableYears)) {
            return '<span class="text-muted">No recorded years available</span>';
        }

        $options = '<option disabled>Select Year</option>';
        foreach ($this->availableYears as $year) {
            $selected = ($year == $this->year) ? 'selected' : '';
            $options .= "<option value=\"$year\" $selected>$year</option>";
        }

        return '
        <div class="row mt-5">
            <div class="col-auto">
                <form method="GET" action="index.php#statistics">
                    <input type="hidden" name="page" value="workout">
                    <select name="year" class="form-select"
                        onchange="this.form.submit()"
                        style="
                            min-width: 150px;
                            background-color: var(--primaryColor);
                            color: var(--text-color-light);
                            background-image: url(\'data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27white%27 viewBox=%270 0 16 16%27%3E%3Cpath d=%27M1.5 5.5l6 6 6-6%27/%3E%3C/svg%3E\');
                            background-repeat: no-repeat;
                            background-position: right 0.75rem center;
                            background-size: 1rem;
                            border: none;
                            padding-right: 2rem;
                        ">
                        ' . $options . '
                    </select>
                </form>
            </div>
        </div>';
    }


    public function getTypeLabels()
    {
        return $this->typeLabels;
    }
    public function getTypeCounts()
    {
        return $this->typeCounts;
    }
    public function getMonthlyLabels()
    {
        return $this->monthlyLabels;
    }
    public function getMonthlyCounts()
    {
        return $this->monthlyCounts;
    }
}
