<?php
session_start();
require_once('db.php');

// Check form task filled?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_task_title = filter_input(INPUT_POST, 'new_task_title', FILTER_SANITIZE_STRING);
    $new_task_description = filter_input(INPUT_POST, 'new_task_description', FILTER_SANITIZE_STRING);
    $new_date = filter_input(INPUT_POST, 'new_date', FILTER_SANITIZE_STRING); // Added to get the date

    try {
        // Insert task into the database with the "Waktu" field
        $sql = "INSERT INTO task (user_id, title, waktu, description) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_SESSION['user']['id'], $new_task_title, $new_date, $new_task_description]);

        header("Location: list_task.php"); // Redirect to the task list
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

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
        <h1>Add New Task</h1>
        <form method="POST" action="add_task.php">
            <div class="task-input-container">
                <label for="new_task_title">Task Title</label>
                <input type="text" class="task-content" id="new_task_title" name="new_task_title" required>
            </div>
            <div class="task-input-container">
                <label for="new_date">Task Date</label>
                <input type="datetime-local" class="task-content" id="new_date" name="new_date" required>
            </div>
            <div class="task-input-container">
                <label for="new_task_description">Task Description</label>
                <textarea class="task-content" id="new_task_description" name="new_task_description" required></textarea>
                <p id="charCount">100 characters remaining</p>
            </div>
            <div>
                <button class="task-btn" type="submit">Add Task</button>
            </div>
        </form>
        <div class="back">
            <p>Go back to <a href="list_task.php">Task List</a></p>
        </div>
    </div>

    <script>
        const descriptionInput = document.getElementById("new_task_description");
        const charCount = document.getElementById("charCount");

        descriptionInput.addEventListener("input", function () {
            const maxChars = 100;
            const currentChars = this.value.length;
            const remainingChars = maxChars - currentChars;
            charCount.textContent = remainingChars + " characters remaining";

            if (remainingChars < 0) {
                this.value = this.value.substring(0, maxChars);
                charCount.textContent = "0 characters remaining";
            }
        });
    </script>
</body>
</html>
