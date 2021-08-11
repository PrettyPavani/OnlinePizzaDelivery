<?php
    include 'dbconnect.php';
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_SESSION['user_id'];    
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $order_id = $_POST["order_id"];
        $message = $_POST["message"];
        $password = $_POST["password"];  
        $passSql = "SELECT * FROM users WHERE id='$user_id'"; 
        $passResult = mysqli_query($conn, $passSql);
        $passRow=mysqli_fetch_assoc($passResult);
        if (password_verify($password, $passRow['password'])){
            $sql = "INSERT INTO `contact` (`user_id`, `email`, `phoneno`, `order_id`, `message`, `time`) VALUES ('$user_id', '$email', '$phone', '$order_id', '$message', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $contact_Id = $conn->insert_id;
            echo '<script>alert("Thanks for Contact us. Your contact id is ' .$contact_id. '. We will contact you very soon.");
                        window.location.href="/OnlinePizzaDelivery/src/controller/users/index.php";  
                        </script>';
                        exit();
        }else{
            echo "<script>alert('Password incorrect!!');
                    window.history.back(1);
                    </script>";
        }
    }
?>