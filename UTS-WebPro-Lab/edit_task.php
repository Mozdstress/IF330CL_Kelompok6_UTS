<?php
session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_NUMBER_INT);
    $new_task_title = filter_input(INPUT_POST, 'new_task_title', FILTER_SANITIZE_STRING);
    $new_task_description = filter_input(INPUT_POST, 'new_task_description', FILTER_SANITIZE_STRING);
    $new_task_date = filter_input(INPUT_POST, 'new_date', FILTER_SANITIZE_STRING); // Get the new date

    try {
        // Update task in the database
        $sql = "UPDATE task SET title = ?, description = ?, waktu = ? WHERE id = ? AND user_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$new_task_title, $new_task_description, $new_task_date, $task_id, $_SESSION['user']['id']]);

        header("Location: list_task.php"); // Redirect to task list after editing
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Handle any database errors here
    }
}

if (isset($_GET['id'])) {
    $task_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Fetch the task from the database
        $sql = "SELECT * FROM task WHERE id = ? AND user_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$task_id, $_SESSION['user']['id']]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$task) {
            echo '<p class="error-message">Task not found.</p>';
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Handle any database errors here
        exit;
    }
} else {
    echo '<p class="error-message">Task ID not provided.</p>';
    exit;
}
?>

<!-- HTML form for editing a task -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="add_edit_task.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>

<body>

    <div class="task-form">
        <h1>Edit Task</h1>
        <form method="POST" action="edit_task.php">
            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
            <div class="task-input-container">
                <label for="new_task_title">Task Title</label>
                <input type="text" class="task-content" id="new_task_title" name="new_task_title" required value="<?php echo $task['title']; ?>">
            </div>
            <div class="task-input-container">
                <label for="new_date">Task Date</label>
                <input type="datetime-local" class="task-content" id="new_date" name="new_date" value="<?php echo date('Y-m-d\TH:i', strtotime($task['waktu'])); ?>" required>
            </div>
            <div class="task-input-container">
                <label for="new_task_description">Task Description</label>
                <textarea class="task-content" id="new_task_description" name="new_task_description" required><?php echo $task['description']; ?></textarea>
            </div>
            <div>
                <button class="task-btn" type="submit">Save Changes</button>
            </div>
        </form>
        <div class="back">
            <p>Go back to <a href="list_task.php">Task List</a></p>
        </div>
    </div>
</body>

</html>