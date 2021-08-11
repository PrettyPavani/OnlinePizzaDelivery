<?php
include 'dbconnect.php';
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    if(isset($_POST['addToCart'])) {
        $itemId = $_POST["itemId"];        
        $existSql = "SELECT * FROM `viewcart` WHERE pizzaId = '$itemId' AND `user_id`='$user_id'";
        $result = mysqli_query($conn, $existSql);
        $numExistRows = mysqli_num_rows($result);
        if($numExistRows > 0){
            echo "<script>alert('Item Already Added.');
                    window.history.back(1);
                    </script>";
        }else{
            $sql = "INSERT INTO `viewcart` (`pizzaId`, `quantity`, `user_id`, `createdate`) VALUES ('$itemId', '1', '$user_id', current_timestamp())";   
            $result = mysqli_query($conn, $sql);
            if ($result){
                echo "<script>
                    window.history.back(1);
                    </script>";
            }
        }
    }
    if(isset($_POST['removeItem'])) {
        $itemId = $_POST["itemId"];
        $sql = "DELETE FROM `viewcart` WHERE `pizzaId`='$itemId' AND `user_id`='$user_id'";   
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('Removed');
                window.history.back(1);
            </script>";
    }
    if(isset($_POST['removeAllItem'])) {
        $sql = "DELETE FROM `viewcart` WHERE `user_id`='$user_id'";   
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('Removed All');
                window.history.back(1);
            </script>";
    }
    if(isset($_POST['checkout'])) {
        $amount = $_POST["amount"];
        $address1 = $_POST["address"];
        $address2 = $_POST["address1"];
        $phone = $_POST["phone"];
        $zipcode = $_POST["zipcode"];
        $password = $_POST["password"];
        $address = $address1.", ".$address2;
        
        $passSql = "SELECT * FROM users WHERE id='$user_id'"; 
        $passResult = mysqli_query($conn, $passSql);
        $passRow=mysqli_fetch_assoc($passResult);
        $userName = $passRow['username'];
        if (password_verify($password, $passRow['password'])){ 
            $sql = "INSERT INTO `orders` (`user_id`, `address`, `zipcode`, `phoneno`, `amount`, `paymentMode`, `status`, `createdate`) VALUES ('$user_id', '$address', '$zipcode', '$phone', '$amount', '0', '0', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $order_id = $conn->insert_id;
            if ($result){
                $addSql = "SELECT * FROM `viewcart` WHERE `user_id`='$user_id'"; 
                $addResult = mysqli_query($conn, $addSql);
                while($addrow = mysqli_fetch_assoc($addResult)){
                    $pizzaId = $addrow['pizzaId'];
                    $quantity = $addrow['quantity'];
                    $itemSql = "INSERT INTO `orderitems` (`order_id`, `pizzaId`, `quantity`) VALUES ('$order_id', '$pizzaId', '$quantity')";
                    $itemResult = mysqli_query($conn, $itemSql);
                }
                $deletesql = "DELETE FROM `viewcart` WHERE `user_id`='$user_id'";   
                $deleteresult = mysqli_query($conn, $deletesql);
                echo '<script>alert("Thanks for ordering with us. Your order id is ' .$order_id. '.");
                    window.location.href="/OnlinePizzaDelivery/src/controller/users/index.php";  
                    </script>';
                    exit();
            }
        }else{
            echo '<script>alert("Incorrect Password! Please enter correct Password.");
                    window.history.back(1);
                    </script>';
                    exit();        }    
    }
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        $pizzaId = $_POST['pizzaId'];
        $qty = $_POST['quantity'];
        $updatesql = "UPDATE `viewcart` SET `quantity`='$qty' WHERE `pizzaId`='$pizzaId' AND `user_id`='$user_id'";
        $updateresult = mysqli_query($conn, $updatesql);
    }
    
}
?>