<?php include('includes/header.php') ;
if(isset($_SESSION['loggedIn'])){
?>
<script>
window.location.href = 'index.php';
</script>
<?php } ?>

<div class="py-5 bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                    <div class="p-5">
                        <?php alertMessage(); ?>
                        <h4 class="text-dark mb-3">Sign into your POS System</h4>
                        <form action="login-code.php" method="post">
                            <div class="mb-3">
                                <label for="">Enter Email</label>
                                <input type="email" name="email" required class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">Enter Password</label>
                                <input type="password" name="password" required class="form-control">
                            </div>
                            <div class="my-3">
                                <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">Sign
                                    In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ;?>