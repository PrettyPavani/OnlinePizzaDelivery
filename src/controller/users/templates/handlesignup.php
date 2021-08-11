<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'dbconnect.php';
    $username = $_POST["username"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];   
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $existSql = "SELECT * FROM `users` WHERE email = '$email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
        $showError = "email Already Exists";
        header("Location: /OnlinePizzaDelivery/src/controller/users/index.php?signupsuccess=false&error=$showError");
    }
    else{
      if(($password == $confirmpassword)){
          $hash = password_hash($password, PASSWORD_DEFAULT);
          $sql = "INSERT INTO `users` ( `username`, `firstName`, `lastName`, `email`, `phone`,`password`, `createDate`) VALUES 
          ('$username', '$firstName', '$lastName', '$email', '$phone', '$hash', current_timestamp())";   
          $result = mysqli_query($conn, $sql);
          if ($result){
              $showAlert = true;
              header("Location: /OnlinePizzaDelivery/src/controller/users/index.php?signupsuccess=true");
          }
      }
      else{
          $showError = "Passwords do not match";
          header("Location: /OnlinePizzaDelivery/src/controller/users/index.php?signupsuccess=false&error=$showError");
      }
    }
}
    
?>