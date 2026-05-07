<?php
ob_start();
session_start();
include "config.php";

// تأكد من استقبال البريد الإلكتروني من الرابط
$patient_email = $_GET['email'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $patient_email) {
    // استقبال بيانات النموذج
    $allergies            = $_POST['allergies'];
    $chronicDiseases      = $_POST['chronic_diseases'];
    $medicationAllergies  = $_POST['medication_allergies'];
    $recentSurgeries      = $_POST['recent_surgeries'];
    $brushingFrequency    = $_POST['brushing_frequency'];
    $smoking              = $_POST['smoking'];

    try {
        $stmt = $conn->prepare("INSERT INTO medical_history 
            (patient_email, allergies, chronic_diseases, medication_allergies, surgeries, brushing_frequency, tobacco_use)
            VALUES (:email, :allergies, :chronic, :medication, :surgeries, :brushing, :tobacco)");

        $stmt->execute([
            ':email'     => $patient_email,
            ':allergies' => $allergies,
            ':chronic'   => $chronicDiseases,
            ':medication'=> $medicationAllergies,
            ':surgeries' => $recentSurgeries,
            ':brushing'  => $brushingFrequency,
            ':tobacco'   => $smoking
        ]);

        header("Location: login.php"); // إعادة توجيه بعد الحفظ
        exit;

    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dental Clinic - Patient Inquiries</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Patient Inquiries</h1>
                </div>
                <form class="user" method="post">
                    <div class="form-group">
                        <label>Do you have any allergies?</label>
                        <textarea class="form-control" name="allergies" rows="2" placeholder="Enter details..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Do you have any chronic diseases?</label>
                        <textarea class="form-control" name="chronic_diseases" rows="2" placeholder="Enter details..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Allergic to medications or substances?</label>
                        <textarea class="form-control" name="medication_allergies" rows="2" placeholder="Enter details..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Undergone any surgeries recently?</label>
                        <textarea class="form-control" name="recent_surgeries" rows="2" placeholder="Enter details..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>How often do you brush your teeth?</label>
                        <input type="text" class="form-control" name="brushing_frequency" placeholder="Enter frequency..." required>
                    </div>
                    <div class="form-group">
                        <label>Do you smoke or use tobacco?</label>
                        <textarea class="form-control" name="smoking" rows="2" placeholder="Enter details..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
</body>
</html>
