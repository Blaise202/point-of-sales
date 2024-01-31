<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="row fw-bold">
        <div class="col-md-12">
            <h1 class="mt-4 text-center">Dashboard</h1>
            <?php alertMessage() ?>
        </div>
        <div class="col-md-12 mb3">
            <h5 class="mt-4 mb-3">Analytics</h5>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-primary p-3">
                <p class="text-sm mb-0 ">Total Categories</p>
                <hr>
                <h5 class="fw-bold mb-3"><?= getcounts('categories'); ?></h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-secondary p-3">
                <p class="text-sm mb-0 ">Total Products</p>
                <hr>
                <h5 class="fw-bold mb-3"><?= getcounts('products'); ?></h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-info p-3">
                <p class="text-sm mb-0 ">Total Admins</p>
                <hr>
                <h5 class="fw-bold mb-3"><?= getcounts('admins'); ?></h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-warning p-3">
                <p class="text-sm mb-0 ">Total Customers</p>
                <hr>
                <h5 class="fw-bold mb-3"><?= getcounts('customers'); ?></h5>
            </div>
        </div>
        <div class="col-md-12 mb3">
            <hr>
            <h5 class="mt-4 mb-3">Orders</h5>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-success p-3">
                <p class="text-sm mb-0 ">Today Orders</p>
                <hr>
                <h5 class="fw-bold mb-3">
                    <?php
                    $todayDate = date('Y-m-d');
                    $todayOrders = mysqli_query($conn, "SELECT * FROM orders WHERE order_date='$todayDate'");
                        echo mysqli_num_rows($todayOrders);
                    ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-light p-3">
                <p class="text-sm mb-0 ">Total Orders Made</p>
                <hr>
                <h5 class="fw-bold mb-3"><?= getcounts('orders'); ?></h5>
            </div>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>