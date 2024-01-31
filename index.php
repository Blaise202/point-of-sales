<?php include('includes/header.php') ;?>

<div class="py-5" style="background-image: url(assets/images/pos-bg.jpg); background-size: cover; ">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 py-5 text-center">
                <?php alertMessage() ?>
                <h1 class="mt-3 text-light">POS System</h1>
                <?php if(!isset($_SESSION['loggedIn'])){ ?>
                <a href="Login.php" class="btn btn-primary mt-4">Login</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ;?>