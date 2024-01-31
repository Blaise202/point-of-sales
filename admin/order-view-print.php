<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Print Order
                <a href="orders.php" class="btn btn-danger mx-2 btn-sm float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <div id="myBillingArea">
                <?php
                    if(isset($_GET['track'])){
                        $trackingNo = validate($_GET['track']);
                        if($trackingNo == ''){
                            ?>
                <div class="text-center py-5">
                    <h5>Provide the products tracking number please.</h5>
                    <a href="orders.php" class="btn btn-primary mt-4 w-25">Back To Orders</a>
                </div>
                <?php
                        }
                        $orderQuery = "SELECT * FROM orders o, customers c 
                        WHERE c.id=o.customer_id AND tracking_no = '$trackingNo' LIMIT 1";
                        $orderQueryRes = mysqli_query($conn, $orderQuery);
                        if(!$orderQueryRes){
                            echo '<h5>Connection to the database failed! The system need to be recovered. </h5>';
                            return false;
                        }
                        if(mysqli_num_rows($orderQueryRes) > 0){
                            $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                            ?>
                <table class="summary-table">
                    <tbody>
                        <tr>
                            <td class=" first-summary-part" colspan="2">
                                <h4> A_Z Company</h4>
                                <p>#555 1st AVE</p>
                                <p>A_Z company logo</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="second-summary-part">
                                <h5><u>Customer details</u></h5>
                                <p>Customer Name: <?= $orderDataRow['name'] ?></p>
                                <p>Customer Phone No: <?= $orderDataRow['phone'] ?></p>
                                <p>Customer Email: <?= $orderDataRow['email'] ?> </p>
                            </td>
                            <td align="end" class="second-summary-part">
                                <h5><u>Invoice Details</u></h5>
                                <p>Invoice No: <?= $orderDataRow['invoice_no'] ?></p>
                                <p>Invoice Date: <?= date('d M Y') ?></p>
                                <p>Address: #555 1st AVE</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php
                        }else{
                            echo'<h5>No Data Found. The traking number provided may be wrong</h5>';
                            return false;
                        }
                        $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.* 
                        FROM orders o, order_items oi, products p
                        WHERE oi.order_id = o.id AND p.id = oi.product_id AND o.tracking_no = '$trackingNo'";
                        $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);
                        if($orderItemQueryRes){
                            if(mysqli_num_rows($orderItemQueryRes) > 0){
                                if(isset($_SESSION['productItems'])){

                                    $sessionProduct = $_SESSION['productItems'];
                                }
                                ?>
                <div class="table-responsive mb-3">
                    <table class="secondTable" cellpadding="5">
                        <thead>
                            <th width="5%">Nº</th>
                            <th>Product Name</th>
                            <th width="10%">Price/Unit</th>
                            <th width="10%">Quantity</th>
                            <th width="15%">Total Price</th>
                        </thead>
                        <tbody>
                            <?php
                                            $i = 1;
                                            foreach($orderItemQueryRes as $key =>$row):
                                            ?>
                            <tr class='tr'>
                                <td><?= $i++ ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?=number_format($row['orderItemPrice'], 0) ?></td>
                                <td><?= $row['orderItemQuantity'] ?></td>
                                <td class="fw-bold">
                                    <?= number_format($row['orderItemPrice']*$row['orderItemQuantity'], 0)  ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr class="grand-total">
                                <td colspan="4" align="end">Grand Total:</td>
                                <td colspan="1"><?= number_format($row['totalAmount'], 0) ?></td>
                            </tr>
                            <tr>
                                <td colspan="5"> Payment Mode: <?= $row['payment_mode'] ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php                    
                            }else{
                                echo'<h5>No Data Found. The traking number provided may be wrong</h5>';
                                return false;
                            }
                        }else{
                            echo '<h5>Connection to the database failed! The system need to be recovered. </h5>';
                            return false;
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
            <div class="mt-4 text-end">
                <button class="btn btn-info px-4 mx-1" onclick='printMyBillingArea()'>Print</button>
                <button class="btn btn-primary px-4 mx-1"
                    onclick="downloadPdf('<?= $orderDataRow['invoice_no'] ?>')">Download Pdf</button>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>