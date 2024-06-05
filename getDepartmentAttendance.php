<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentYear = date('Y');
$currentMonth = date('n');


$sql = "SELECT id, department FROM department";
$departmentsResult = $conn->query($sql);

$departments = [];
while ($row = $departmentsResult->fetch_assoc()) {
    $departments[$row['id']] = [
        'name' => $row['department'],
        'users' => [],
        'monthly' => array_fill(1, 12, ['status' => 'Not recorded yet']),
        'yearly' => [
            'present' => 0,
            'absent' => 0
        ]
    ];
}


$sql = "SELECT id, name, email, department_id FROM registration";
$usersResult = $conn->query($sql);

while ($row = $usersResult->fetch_assoc()) {
    $departments[$row['department_id']]['users'][$row['email']] = [
        'name' => $row['name'],
        'email' => $row['email'],
        'monthly' => array_fill(1, 12, ['present' => 0, 'absent' => 0, 'status' => 'Not recorded yet']),
        'yearly' => [
            'present' => 0,
            'absent' => 0
        ]
    ];
}


foreach ($departments as $deptId => $dept) {
    for ($month = 1; $month <= 12; $month++) {
        if ($month > $currentMonth) {
            continue;
        }

        $firstDayOfMonth = date('Y-m-01', strtotime("$currentYear-$month-01"));
        $lastDayOfMonth = date('Y-m-t', strtotime("$currentYear-$month-01"));

        foreach ($dept['users'] as $email => $user) {
            $sql = "SELECT attendance, time FROM attendance WHERE email = '$email' AND time BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
            $result = $conn->query($sql);

            $presentDays = 0;
            $absentDays = 0;

            while ($row = $result->fetch_assoc()) {
                if ($row['attendance'] === 'present') {
                    $presentDays++;
                }
            }

            // Calculating absent days excluding Sundays
            $startDate = new DateTime($firstDayOfMonth);
            $endDate = new DateTime($lastDayOfMonth);
            $interval = new DateInterval('P1D');
            $dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

            foreach ($dateRange as $date) {
                if ($date->format('N') != 7) { // Exclude Sundays
                    if (!in_array($date->format('Y-m-d'), array_column($result->fetch_all(), 'time'))) {
                        $absentDays++;
                    }
                }
            }

            $departments[$deptId]['users'][$email]['monthly'][$month] = [
                'present' => $presentDays,
                'absent' => $absentDays,
                'status' => 'Recorded'
            ];

            $departments[$deptId]['users'][$email]['yearly']['present'] += $presentDays;
            $departments[$deptId]['users'][$email]['yearly']['absent'] += $absentDays;

            $departments[$deptId]['yearly']['present'] += $presentDays;
            $departments[$deptId]['yearly']['absent'] += $absentDays;
        }
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($departments);
?>
