<?php
  session_start();
  
  // Load name to result
  $result->name = $_SESSION['id'];
  
  // Return result
  exit(json_encode($result));
?>