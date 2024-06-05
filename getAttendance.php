<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_GET['email'];
$currentYear = date('Y');


$sql = "SELECT name FROM registration WHERE email = '$email'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();


$yearlyAttendance = [
    'present' => 0,
    'absent' => 0,
];
$monthlyAttendance = [];
$absentDates = [];
$presentDates = [];

for ($month = 1; $month <= 12; $month++) {
    $firstDayOfMonth = date('Y-m-01', strtotime("$currentYear-$month-01"));
    $lastDayOfMonth = date('Y-m-t', strtotime("$currentYear-$month-01"));

    
    $sql = "SELECT attendance, time FROM attendance WHERE email = '$email' AND time BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
    $result = $conn->query($sql);

    $presentDays = 0;
    $absentDays = 0;
    $absentDatesInMonth = [];
    $presentDatesInMonth = [];

    while ($row = $result->fetch_assoc()) {
        $attendanceDate = date('Y-m-d', strtotime($row['time']));
        if ($row['attendance'] === 'present') {
            $presentDays++;
            $presentDatesInMonth[] = [
                'date' => $attendanceDate,
                'time' => date('H:i:s', strtotime($row['time']))
            ];
        }
    }

    
    $startDate = new DateTime($firstDayOfMonth);
    $endDate = new DateTime($lastDayOfMonth);
    $interval = new DateInterval('P1D');
    $dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

    foreach ($dateRange as $date) {
        if ($date->format('N') != 7) { 
            if (!in_array($date->format('Y-m-d'), array_column($presentDatesInMonth, 'date'))) {
                $absentDays++;
                $absentDatesInMonth[] = $date->format('Y-m-d');
            }
        }
    }

    
    $monthlyAttendance[date('F', mktime(0, 0, 0, $month, 10))] = [
        'present' => $presentDays,
        'absent' => $absentDays,
        'presentDates' => $presentDatesInMonth,
        'absentDates' => $absentDatesInMonth,
        'status' => $month > date('n') ? 'Not recorded yet' : 'Recorded'
    ];
    $absentDates = array_merge($absentDates, $absentDatesInMonth);
    $presentDates = array_merge($presentDates, $presentDatesInMonth);

    $yearlyAttendance['present'] += $presentDays;
    $yearlyAttendance['absent'] += $absentDays;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode([
    'name' => $user['name'],
    'yearly' => $yearlyAttendance,
    'monthly' => $monthlyAttendance,
    'absentDates' => $absentDates,
    'presentDates' => $presentDates,
]);
?>