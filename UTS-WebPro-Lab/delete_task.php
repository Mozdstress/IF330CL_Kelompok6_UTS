<?php
session_start();
require_once('db.php');

// Check apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $task_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Delete task
        $sql = "DELETE FROM task WHERE id = ? AND user_id = ?";
        $stmt = $db->prepare($sql);

        $stmt->execute([$task_id, $_SESSION['user']['id']]);
        header("Location: list_task.php"); // Redirect to task list after deleting
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Handling error
    }
}
?>