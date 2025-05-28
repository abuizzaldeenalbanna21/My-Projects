<?php
include "database.php";


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = new Database($conn);
    $db->delete('doctors', ['id' => $id]);
}


header('Location: users.php');
