<?php
session_start();
session_destroy();
sleep(1);
header("location: akademisyenGiris.php");
exit();
?>
