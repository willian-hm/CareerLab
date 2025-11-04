<?php
session_start();
session_destroy();
header("Location: login-mentor.php");
exit;
?>
