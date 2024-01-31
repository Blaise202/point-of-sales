<?php include('includes/header.php'); ?>
<!-- Modal -->
<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Enter Customer Name</label>
                    <input type="text" id="c_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Enter Customer Phone Nº</label>
                    <input type="number" id="c_phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Enter Customer Email (optional)</label>
                    <input type="text" id="c_email" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary saveCustomer">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Order
                <a href="orders.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="orders-code.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Select Product</label>
                        <select name="product_id" class="form-select mySelect2">
                            <option value="">--Select Product--</option>
                            <?php
                            $products = getAll('products');
                            if($products){
                                foreach($products as $product){
                                ?>
                            <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                            <?php
                                }
                            }else{
                               ?>
                            <option value="" class="text-danger">Oops! No product found</option>
                            <?php 
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Quantity</label>
                        <input type="number" name="quantity" value="1" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3 text">
                        <br>
                        <button name="AddItem" type="submit" class="btn btn-primary float-end">Add Item</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Orders</h4>
        </div>
        <div class="card-body" id="productArea">
            <?php
            if(isset($_SESSION['productItems'])){
                $sessionProduct = $_SESSION['productItems'];
                if(empty($sessionProduct)){
                    unset($_SESSION['productItemIds']);
                    unset($_SESSION['productItems']);
                }
            }
                if(isset($_SESSION['productItems'])){
                ?>
            <div class="table-responsive mb-3" id="productContent">
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Toyal Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach($_SESSION['productItems'] as $key=>$item):
                            ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['price'] ?></td>
                            <td>
                                <div class="input-group qtyBox">
                                    <input type="hidden" value="<?= $item['product_id'] ?>" class="prodId"></input>
                                    <button class="input-group-text decrement">-</button>
                                    <input type="text" value="<?= $item['quantity'] ?>" class="qty quantityInput">
                                    <button class="input-group-text increment">+</button>
                                </div>
                            </td>
                            <td><?= number_format($item['price'] * $item['quantity'], 0)?></td>
                            <td>
                                <a href="order-item-delete.php?index=<?=$key?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label>Select Payment Method</label>
                        <select id="payment_mode" class="form-select">
                            <option value="">--Select Payment--</option>
                            <option value="Cash Payment">Cash Payment</option>
                            <option value="Online Payment">Online Payment</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Enter customer Phone Number</label>
                        <input type="number" id="cphone" value="" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <br>
                        <button type="button" class="btn btn-warning w-100 proceedToPlace">Proceed To Place
                            Order</button>
                    </div>
                </div>
            </div>
            <?php
            }else{
                echo '<h5> No Orders Made yet</h5>';
            }
            ?>

        </div>

    </div>

</div>


<?php include('includes/footer.php'); ?>