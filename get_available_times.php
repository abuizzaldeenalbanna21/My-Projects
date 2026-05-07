<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);

// التحقق من إرسال التاريخ
if (!isset($_GET['date'])) {
    echo json_encode([]);
    exit;
}

$date = $_GET['date'];

// إنشاء قائمة الأوقات بين 11:00 و 19:00 بفواصل 30 دقيقة
$start = strtotime('11:00');
$end = strtotime('19:00');
$interval = 30 * 60;
$allTimes = [];

for ($time = $start; $time <= $end; $time += $interval) {
    $allTimes[] = date('H:i', $time); // e.g. 11:00
}

// جلب الأوقات المحجوزة من قاعدة البيانات بصيغة HH:MM
$stmt = $conn->prepare("SELECT TIME_FORMAT(`time`, '%H:%i') as booked_time FROM appointments WHERE `date` = ?");
$stmt->execute([$date]);
$bookedTimes = $stmt->fetchAll(PDO::FETCH_COLUMN);

// طرح الأوقات المحجوزة من كل الأوقات
$availableTimes = array_diff($allTimes, $bookedTimes);

// إعادة ترتيب الفهرس (مطلوبة للـ JSON)
echo json_encode(array_values($availableTimes));
?>