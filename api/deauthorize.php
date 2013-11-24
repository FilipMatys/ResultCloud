?php
  session_start();

  $_SESSION = array();
  session_destroy();
  
  $result = true;
  exit(json_encode($result));
?>