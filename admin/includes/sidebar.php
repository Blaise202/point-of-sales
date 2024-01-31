<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
?>


<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?= $page == 'index.php'? 'active bg-light text-dark ':'' ?>" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link <?= $page == 'order-create.php'? 'active bg-light text-dark ':'' ?>"
                    href="order-create.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Make An Order
                </a>
                <a class="nav-link <?= $page == 'orders.php'? 'active bg-light text-dark  ':'' ?>" href="orders.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Pending Orders
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapse <?=( $page == 'categories.php')||($page == 'category-create.php')? 'active':'' ?>"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false"
                    aria-controls="collapseCategory">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Categories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $page == 'categories.php'? 'show':'' ?> <?= $page == 'category-create.php'? 'show ':'' ?>"
                    id="collapseCategory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'category-create.php'? 'active bg-light text-dark ':'' ?>"
                            href="category-create.php">Create Category</a>
                        <a class="nav-link <?= $page == 'categories.php'? 'active bg-light text-dark ':'' ?>"
                            href="categories.php">View
                            Categories</a>
                    </nav>
                </div>
                <a class="nav-link collapse <?= ($page == 'products.php') || ($page == 'product-create.php')? 'active':'' ?>"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseProduct" aria-expanded="false"
                    aria-controls="collapseProduct">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $page == 'products.php'? 'show':'' ?> <?= $page == 'product-create.php'? 'show':'' ?>"
                    id="collapseProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'product-create.php'? 'active bg-light text-dark ':'' ?>"
                            href="product-create.php">Create Product</a>
                        <a class="nav-link <?= $page == 'products.php'? 'active bg-light text-dark ':'' ?>"
                            href="products.php">View Products</a>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Manage Users</div>
                <a class="nav-link collapse <?= ($page == 'customers.php') || ($page == 'customer-create.php')? 'active':'' ?>"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapsecustomers" aria-expanded="false"
                    aria-controls="collapsecustomers">
                    <div class="sb-nav-link-icon"><i class="fa-brands fa-intercom"></i></div>
                    Customers
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $page == 'customers.php'? 'show':'' ?> <?= $page == 'customer-create.php'? 'show':'' ?>"
                    id="collapsecustomers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'customer-create.php'? 'active bg-light text-dark ':'' ?>"
                            href="customer-create.php">Add Customer</a>
                        <a class="nav-link <?= $page == 'customers.php'? 'active bg-light text-dark ':'' ?>"
                            href="customers.php">View customers</a>
                    </nav>
                </div>
                <a class="nav-link collapse <?= ($page == 'admins.php') || ($page == 'admins-create.php')? 'active':'' ?>"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmins" aria-expanded="false"
                    aria-controls="collapseAdmins">
                    <div class="sb-nav-link-icon"><i class="fa-sharp fa-thin fa-users"></i></div>
                    Admins/Staff
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $page == 'admins.php'? 'show':'' ?> <?= $page == 'admins-create.php'? 'show':'' ?>"
                    id="collapseAdmins" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'admins-create.php'? 'active bg-light text-dark ':'' ?>"
                            href="admins-create.php">Add Admin</a>
                        <a class="nav-link <?= $page == 'admins.php'? 'active bg-light text-dark ':'' ?>"
                            href="admins.php">View Admins</a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>