<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Tracker</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Homemade+Apple&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap">
  <link rel="stylesheet" href="list_task.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <nav class="navbar">
      <div class="container">
        <a href="#" class="logo">
          <img src="img/logo.png" alt="Task Tracker Logo">
        </a>
        <ul class="nav-links">
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
    <div class="header">
      <?php
      // Check if user is logged in
      if (!isset($_SESSION['user'])) {
        // User not logged in, display error message
        echo '<p class="alert alert-danger">Please login first.</p>';
      } else {
        echo '<h2 id="title" class="head_title">To-Do List</h2>';
        // Display welcome message
        echo '<p class="username-display">Hi, ' . $_SESSION['user']['username'] . '!</p>';

        echo '</div>';
        // Connect to the database
        $db = new PDO(DSN, DBUSER, DBPASS);

        // Fetch tasks from the database
        $sql = "SELECT * FROM task WHERE user_id = ? ORDER BY done_at DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([$_SESSION['user']['id']]);
        $tasks = $stmt->fetchAll();

        $tasksByProgress = [
          'not_started' => [],
          'in_progress' => [],
          'done' => [],
        ];

        foreach ($tasks as $task) {
          $tasksByProgress[$task['progress']][] = $task;
        }
        $sortedTasks = array_merge($tasksByProgress['not_started'], $tasksByProgress['in_progress'], $tasksByProgress['done']);

      ?>
        <button class="center-button" onclick="location.href='add_task.php';">
          <span class="shadow"></span>
          <span class="edge"></span>
          <span class="front">Add New Task</span>
        </button>

        <?php
        foreach ($sortedTasks as $task) {
          $isDone = ($task['progress'] === 'done');
          $cardTitleClass = $isDone ? 'done' : '';
          $cardSubtitleClass = $isDone ? 'done' : '';
          $cardTextClass = $isDone ? 'done' : '';
        ?>
          <div data-aos="fade-up" data-aos-offset="50">
            <div class="card mb-3">
              <div class="card-body">
                <div class="card-content justify-content-between align-items-center">
                  <div>
                    <h5 class="card-title <?php echo $isDone ? 'done' : ''; ?>"><?php echo $task['title']; ?></h5>
                    <h4 class="card-subtitle <?php echo $isDone ? 'done' : ''; ?>"><?php echo $task['waktu']; ?></h4>
                    <p class="card-text <?php echo $isDone ? 'done' : ''; ?>"><?php echo $task['description']; ?></p>
                  </div>
                  <div class="text-center">
                    <label class="checkbox-label">
                      <input type="checkbox" onclick="markAsDone(this, <?php echo $task['id']; ?>)" <?php echo ($task['progress'] === 'done') ? 'checked' : ''; ?>>
                      <span class="checkmark"></span>
                    </label>
                    <span class="done-text">Done</span>
                    <div class="btn-container">
                      <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-primary">Edit</a>
                      <a href="javascript:void(0);" class="btn btn-danger" onclick="showDeleteConfirmation(<?php echo $task['id']; ?>)">Delete</a>
                    </div>
                    <select onchange="updateProgress(this, <?php echo $task['id']; ?>)">
                      <option value="not_started" <?php echo ($task['progress'] == 'not_started') ? 'selected' : ''; ?>>Not Yet Started</option>
                      <option value="in_progress" <?php echo ($task['progress'] == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                      <option value="done" <?php echo ($task['progress'] == 'done') ? 'selected' : ''; ?>>Done</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="deleteConfirmation" class="modal">
            <div class="modal-content">
              <p>Apakah Anda yakin ingin menghapus tugas ini?</p>
              <button class="confirm-button" onclick="deleteTask(<?php echo $task['id']; ?>)">Ya</button>
              <button class="close-button" onclick="closeDeleteConfirmation()">Tidak</button>
            </div>
          </div>

      <?php
        } // end foreach
      }
      ?>
      <script>
        function markAsDone(checkbox, taskId) {
          const isDone = checkbox.checked;
          const progress = isDone ? 'done' : 'not_started';

          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'update_progress.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              location.reload();
            }
          };
          xhr.send(`task_id=${taskId}&progress=${progress}`);
        }

        function showDeleteConfirmation(taskId) {
          const modal = document.getElementById('deleteConfirmation');
          modal.style.display = 'block';

          // Simpan ID tugas yang akan dihapus
          modal.dataset.taskId = taskId;
        }

        function closeDeleteConfirmation() {
          const modal = document.getElementById('deleteConfirmation');
          modal.style.display = 'none';
        }

        function deleteTask(taskId) {
          // Ambil ID tugas yang akan dihapus dari modal
          taskId = document.getElementById('deleteConfirmation').dataset.taskId;

          // Eksekusi penghapusan tugas dengan mengarahkan ke delete_task.php
          window.location.href = 'delete_task.php?id=' + taskId;
        }

        function updateProgress(select, taskId) {
          const progress = select.value;
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'update_progress.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Refresh the page after changing the progress
              location.reload();
            }
          };
          xhr.send(`task_id=${taskId}&progress=${progress}`);
        }
      </script>
      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
      <script>
        AOS.init();
      </script>
    </div>
  </div>
</body>

</html>