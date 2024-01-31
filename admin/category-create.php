<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Category
                <a href="categories.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description *</label>
                        <textarea type="text" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Status<i class="text-danger"> (Unchecked= visible, Checked=hidden)</i></label><br>
                        <input type="checkbox" name="status" style="width: 30px; height: 30px">
                    </div>
                    <div class="col-md-6 mb-3 text">
                        <button name="SaveCategory" type="submit" class="btn btn-primary float-end">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>