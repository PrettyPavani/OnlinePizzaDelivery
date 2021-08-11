<?php

session_start();
echo "Logging you out. Please wait...";
unset($_SESSION["adminloggedin"]);
unset($_SESSION["adminusername"]);
unset($_SESSION["adminuser_id"]);

// session_unset();
// session_destroy();

header("location: /OnlinePizzaDelivery/src/controller/users/index.php" );
?>
