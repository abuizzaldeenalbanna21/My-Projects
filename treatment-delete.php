<?php
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $deleted = $db->delete('treatments', ['id' => $id]);

    if ($deleted) {
        header("Location: treatment.php?success=deleted");
        exit;
    } else {
        echo "Failed to delete treatment.";
    }
} else {
    echo "Invalid treatment ID.";
}
