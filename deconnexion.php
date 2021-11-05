<?php
session_start();
session_destroy();
session_unset();

setcookie('log','',time()-3444,'/',null, false,true);

header('location: index.php')
?>