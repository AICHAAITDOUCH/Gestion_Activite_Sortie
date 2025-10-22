<?php
session_start();
session_destroy();
header("Location: Sign-In.php");
exit();
?>
