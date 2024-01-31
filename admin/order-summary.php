<?php include('includes/header.php') ;
if(!isset($_SESSION['productItems'])){
    echo '<script>window.location.href ="order-create.php"; </script>';
}
?>

<div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <h4 id="orderPlaceSuccessMessage"></h4>
                </div>
                <a href="orders.php" class="btn btn-secondary">Cancel</a>
                <button type="button" onclick='printMyBillingArea()' class="btn btn-danger ">Print</button>
                <button type="button" onclick="downloadPdf('<?= $_SESSION['invoice_no'] ?>')"
                    class="btn btn-warning ">Download Pdf</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="mb-4">
                        Order Summary
                        <a class="btn btn-danger float-end" href="order-create.php">Back to create order</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php alertMessage(); ?>
                    <div id="myBillingArea">
                        <?php 
                        if(isset($_SESSION['cphone'])){
                            $phone = validate($_SESSION['cphone']);
                            $inv_no = validate($_SESSION['invoice_no']);
                            $getCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' LIMIT 1");
                            if($getCustomer){
                                if(mysqli_num_rows($getCustomer) > 0){
                                    $cRowData = mysqli_fetch_assoc($getCustomer);
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
                                        <h5>Customer details</h5>
                                        <p>Customer Name: <?= $cRowData['name'] ?></p>
                                        <p>Customer Phone No: <?= $cRowData['phone'] ?></p>
                                        <p>Customer Email: <?= $cRowData['email'] ?> </p>
                                    </td>
                                    <td align="end" class="second-summary-part">
                                        <h5>Invoice Details</h5>
                                        <p>Invoice No: <?= $inv_no ?></p>
                                        <p>Invoice Date: <?= date('d M Y') ?></p>
                                        <p>Address: #555 1st AVE</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                                }else{
                                    echo '<h5>Customer data not found</h5>';
                                    return;
                                }
                            }
                        }
                        if(isset($_SESSION['productItems'])){
                        $sessionProduct = $_SESSION['productItems'];
                        ?>
                        <div class="table-responsive-mb-3">
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
                                    $totalAmount = 0;
                                    foreach($sessionProduct as $key =>$row):
                                        $totalAmount += $row['price']*$row['quantity'];
                                    ?>
                                    <tr class='tr'>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?=number_format($row['price'], 0) ?></td>
                                        <td><?= $row['quantity'] ?></td>
                                        <td class="fw-bold">
                                            <?= number_format($row['price']*$row['quantity'], 0)  ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr class="grand-total">
                                        <td colspan="4" align="end">Grand Total:</td>
                                        <td colspan="1"><?= number_format($totalAmount, 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"> Payment Mode: <?= $_SESSION['payment_mode'] ?> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        }else{
                            echo'<h5 class="text-center">No Items Found</h5>';
                        }
                        ?>
                    </div>
                    <?php if(isset($_SESSION['productItems'])): ?>
                    <div class="mt-4 text-end">
                        <button type="button" id="saveOrder" class="btn btn-primary px-4">Save</button>
                        <button type="button" onclick='printMyBillingArea()' class="btn btn-danger ">Print</button>
                        <button type="button" onclick="downloadPdf('<?= $_SESSION['invoice_no'] ?>')"
                            class="btn btn-warning ">Download Pdf</button>
                    </div>
                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>