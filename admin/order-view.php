<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Order View
                <a href="orders.php" class="btn btn-danger mx-2 btn-sm float-end">Back</a>
                <a href="order-view-print.php?track=<?= $_GET['track']?>"
                    class="btn btn-info mx-2 btn-sm float-end">Print</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            if(isset($_GET['track'])){
                $trackingNo = validate($_GET['track']);
                $query = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id AND tracking_no = '$trackingNo' ORDER BY o.id DESC";
                $orders = mysqli_query($conn, $query);
                if($orders){
                    if(mysqli_num_rows($orders) > 0){
                        $orderData = mysqli_fetch_assoc($orders);
                        $orderId = $orderData['id'];
                        ?>
            <div class="card card-body shadow border-1 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Order Details</h4>
                        <label class="mb-1">
                            Tracking No: <span class="fw-bold"><?= $orderData['tracking_no'] ?></span>
                        </label>
                        <br>
                        <label class="mb-1">
                            Order Date: <span class="fw-bold"><?= $orderData['order_date'] ?></span>
                        </label>
                        <br>
                        <label class="mb-1">
                            Order Status: <span class="fw-bold"><?= $orderData['order_status'] ?></span>
                        </label>
                        <br>
                        <label class="mb-1">
                            Payment Mode: <span class="fw-bold"><?= $orderData['payment_mode'] ?></span>
                        </label>
                        <br>

                    </div>
                    <div class="col-md-6">
                        <h4>Customer Details</h4>
                        <label class="mb-1">
                            Customer Name: <span class="fw-bold"><?= $orderData['name'] ?></span>
                        </label>
                        <br>
                        <label class="mb-1">
                            Customer Email: <span class="fw-bold"><?= $orderData['email'] ?></span>
                        </label>
                        <br>
                        <label class="mb-1">
                            Phone Number: <span class="fw-bold"><?= $orderData['phone'] ?></span>
                        </label>
                        <br>
                    </div>
                </div>
            </div>
            <?php
            $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.*
                               FROM orders as o, order_items as oi, products as p
                               WHERE oi.order_id = o.id AND p.id=oi.product_id AND o.tracking_no = '$trackingNo'";
            $orderItemRes = mysqli_query($conn, $orderItemQuery);
            if(mysqli_num_rows($orderItemRes) > 0){
                ?>
            <h4 class="my-3">Order Items Details</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Prduct</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orderItemRes as $orderItemRow){ ?>
                    <tr>
                        <td>
                            <img src="<?= $orderItemRow['image'] != ''? '../'.$orderItemRow['image'] : '../assets/uploads/no-img.jpg' ?>"
                                style="width:50px; height: 50px;" alt="">
                            <?= $orderItemRow['name'] ?>
                        </td>
                        <td width="15%" class="fw-bold text-center">
                            <?= number_format($orderItemRow['orderItemPrice'],0 )?></td>
                        <td width="15%" class="fw-bold text-center">
                            <?= $orderItemRow['orderItemQuantity'] ?></td>
                        <td width="15%" class="fw-bold text-center">
                            <?= number_format($orderItemRow['orderItemPrice'] * $orderItemRow['orderItemQuantity'],0) ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="text-end fw-bold">Total Price:</td>
                        <td colspan="3" class="text-end fw-bold">Rs:
                            <?= number_format($orderItemRow['totalAmount'],0) ?></td>
                    </tr>
                </tbody>
            </table>
            <?php
            }else{
                echo '<h5>No Item Found</h5>';
                return false;
            }
            ?>
            <?php
                    }else{
                        ?>
            <div class="text-center py-5">
                <h5>No Tracking Number Found</h5>
                <a href="orders.php" class="btn btn-primary mt-4 w-25">Back To Orders</a>
            </div>
            <?php
                    }
                }else{
                    echo '<h5>The connection to the database failed</h5>';
                }
            }else{
                ?>
            <div class="text-center py-5">
                <h5>No Tracking Number Found</h5>
                <a href="orders.php" class="btn btn-primary mt-4 w-25">Back To Orders</a>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>