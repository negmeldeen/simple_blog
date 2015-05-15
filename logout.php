<?php
session_start();

session_destroy();
setcookie("username","",time()-7200);
header("location: log_in.php");

?>