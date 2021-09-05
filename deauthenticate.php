<?php

// Logout (start session -> destroy session -> redirect to login page)
session_start();
session_destroy();
header("location:manager.php");

?>