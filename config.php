<?php
try {
    $conn = new PDO("mysql:host=172.26.144.93;dbname=dental_clinic;charset=utf8", "test", "7285");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
