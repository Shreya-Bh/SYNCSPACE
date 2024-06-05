<?php
session_start();
$email = $_SESSION['email'];
$year = $_GET['year'];
$month = $_GET['month'];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstDayOfMonth = "$year-$month-01";
$lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

$sql = "SELECT attendance, time FROM attendance WHERE email = '$email' AND time BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
$result = $conn->query($sql);

$presentDays = 0;
$absentDays = 0;
$absentDates = [];
$attendanceData = [];

while ($row = $result->fetch_assoc()) {
    if ($row['attendance'] === 'present') {
        $presentDays++;
    } else {
        $absentDays++;
        $absentDates[] = $row['time'];
    }
}

// Calculates absent days excluding Sundays
$startDate = new DateTime($firstDayOfMonth);
$endDate = new DateTime($lastDayOfMonth);
$interval = new DateInterval('P1D');
$dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

foreach ($dateRange as $date) {
    if ($date->format('N') != 7 && !in_array($date->format('Y-m-d'), $absentDates)) {
        $absentDays++;
        $absentDates[] = $date->format('Y-m-d');
    }
}

$conn->close();


header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="Attendance_Report.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Email', 'Year', 'Month', 'Total Present Days', 'Total Absent Days']);
fputcsv($output, [$email, $year, date('F', strtotime($firstDayOfMonth)), $presentDays, $absentDays]);

fputcsv($output, []);
fputcsv($output, ['Absent Dates']);
foreach ($absentDates as $date) {
    fputcsv($output, [$date]);
}

fclose($output);
?>
