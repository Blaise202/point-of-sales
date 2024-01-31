<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0">Orders </h4>
                </div>
                <div class="col-md-8">
                    <form action="" method="get">
                        <div class="row g-1">
                            <div class="col-md-4">
                                <input type="date" name="date" class="form-control"
                                    value="<?= isset($_GET['date']) ==true ? $_GET['date']: '' ?>" />
                            </div>
                            <div class="col-md-4">
                                <select name="payment_mode" class="form-select">
                                    <option value="">--Select Payment--</option>
                                    <option value="Cash Payment"
                                        <?= isset($_GET['payment_mode'])==true?($_GET['payment_mode']=='Cash payment' ? 'selected':''):''  ?>>
                                        Cash Payment</option>
                                    <option value="Online Payment"
                                        <?= isset($_GET['payment_mode'])==true?($_GET['payment_mode']=='Online payment'?'selected':''):''  ?>>
                                        Online Payment</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                                <a href="orders.php" class="btn btn-danger"><i class="fa-solid fa-arrows-rotate"></i><a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php 
            if(isset($_GET['date'])|| isset($_GET['payment_mode'])){
                $orderDate = validate($_GET['date']);
                $payment_mode = validate($_GET['payment_mode']);
                if($orderDate!='' && $payment_mode==''){
                    $query = "SELECT o.*, c.* FROM orders o, customers c
                    WHERE c.id = o.customer_id AND o.order_date = '$orderDate' ORDER BY o.id DESC";
                }elseif($orderDate=='' && $payment_mode!=''){
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                    WHERE c.id = o.customer_id AND o.payment_mode = '$payment_mode' ORDER BY o.id DESC";
                }elseif($orderDate!='' && $payment_mode!=''){
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                    WHERE c.id = o.customer_id AND o.payment_mode = '$payment_mode' AND o.order_date = '$orderDate' ORDER BY o.id DESC";
                }else{
                    $query = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id ORDER BY o.id DESC";
                }
            }else{
                $query = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id ORDER BY o.id DESC";
            }
            $orders = mysqli_query($conn, $query);
            if($orders){
                if(mysqli_num_rows($orders)>0){
                    ?>
            <table class="table table-striped table-bordered align-items-center justify-content-center">
                <thead>
                    <tr>
                        <th>Tracking No</th>
                        <th>C Name</th>
                        <th>C Phone</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order){ ?>
                    <tr>
                        <td class="fw-bold"><?= $order['tracking_no'] ?></td>
                        <td><?= $order['name'] ?></td>
                        <td><?= $order['phone'] ?></td>
                        <td><?= date('d M, Y', strtotime($order['order_date'])) ?></td>
                        <td><?= $order['order_status'] ?></td>
                        <td><?= $order['payment_mode'] ?></td>
                        <td>
                            <a href="order-view.php?track=<?= $order['tracking_no'] ?>"
                                class="btn btn-info mb-0 btn-sm">View</a>
                            <a href="order-view-print.php?track=<?= $order['tracking_no'] ?>"
                                class="btn btn-primary mb-0 btn-sm">Print</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
                }else{
                    echo '<h5>No Orders Made </h5>';
                }
            }else{
            echo '<h5>The Connection to The database Failed</h5>';
        }
            ?>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>