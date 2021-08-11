<?php 
    $itemModalSql = "SELECT * FROM `orders` WHERE `user_id`= $user_id";
    $itemModalResult = mysqli_query($conn, $itemModalSql);
    while($itemModalRow = mysqli_fetch_assoc($itemModalResult)){
        $order_id = $itemModalRow['order_id'];    
?>
<div class="modal fade" id="orderItem<?php echo $order_id; ?>" tabindex="-1" role="dialog" aria-labelledby="orderItem<?php echo $order_id; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderItem<?php echo $order_id; ?>">Order Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">            
                <div class="container">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table text">
                            <thead>
                                <tr>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="px-3">Item</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="text-center">Quantity</div>
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $mysql = "SELECT * FROM `orderitems` WHERE order_id = $order_id";
                                    $myresult = mysqli_query($conn, $mysql);
                                    while($myrow = mysqli_fetch_assoc($myresult)){
                                        $pizzaId = $myrow['pizzaId'];
                                        $quantity = $myrow['quantity'];                                        
                                        $itemsql = "SELECT * FROM `pizza` WHERE pizzaId = $pizzaId";
                                        $itemresult = mysqli_query($conn, $itemsql);
                                        $itemrow = mysqli_fetch_assoc($itemresult);
                                        $name = $itemrow['name'];
                                        $price = $itemrow['price'];
                                        $desc = $itemrow['desc'];
                                        $categorie_id = $itemrow['categorie_id'];
                                        echo '<tr>
                                                <th scope="row">
                                                    <div class="p-2">
                                                    <img src="img/pizza-'.$pizzaId. '.jpg" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                    <div class="ml-3 d-inline-block align-middle">
                                                        <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">'.$name. '</a></h5><span class="text-muted font-weight-normal font-italic d-block">Rs. ' .$price. '/-</span>
                                                    </div>
                                                    </div>
                                                </th>
                                                <td class="align-middle text-center"><strong>' .$quantity. '</strong></td>
                                            </tr>';
                                    }
                                ?>
                            </tbody>
                            </table>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>