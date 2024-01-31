<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Product
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Select Category</label>
                        <select name="category_id" id="" class="form-select">
                            <option value=""></option>
                            <?php
                            $categories = getAll('categories');
                            if($categories){
                                foreach($categories as $category){
                                ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>

                            <?php
                                }
                            }else{
                                echo '<option value"">Categories not found? Ask what is wrong</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label>Product Name *</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Description *</label>
                        <textarea type="text" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Product price *</label>
                        <input type="number" name="price" required class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Product Quantity *</label>
                        <input type="number" name="quantity" required class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Product Image *</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status<i class="text-danger"> (Unchecked= visible, Checked=hidden)</i></label><br>
                        <input type="checkbox" name="status" style="width: 30px; height: 30px">
                    </div>
                    <div class="col-md-6 mb-3 text">
                        <button name="SaveProduct" type="submit" class="btn btn-primary float-end">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>