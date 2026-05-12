<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
requireAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
if ($stmt->execute([$id])) {
    $_SESSION['message'] = "Student deleted successfully!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Failed to delete student.";
    $_SESSION['message_type'] = "error";
}

header("Location: list.php");
exit;
?>