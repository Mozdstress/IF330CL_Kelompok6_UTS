<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
  }
  
  if (isset($_POST['task_id']) && isset($_POST['progress'])) {
    $taskId = $_POST['task_id'];
    $progress = $_POST['progress'];
    $date = date('Y-m-d H:i:s');
    
  
    // connect db
    $db = new PDO(DSN, DBUSER, DBPASS);
  
    // Periksa task id
    $sql = "SELECT user_id FROM task WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$taskId]);
    $task = $stmt->fetch();
  
    if ($task && $task['user_id'] === $_SESSION['user']['id']) {

      $sql = "UPDATE task SET done_at = ?, progress = ? WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->execute([$date, $progress, $taskId]);
    } else {
     
      exit();
    }
  }
  