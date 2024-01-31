<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Product
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <?php
                $paramValue = getParamId('id');
                if(!is_numeric($paramValue)){
                    echo '<h5>Id is not an integer.</h5>';
                    return false;
                }
                $product = getById('products', $paramValue);
                if($product){
                    if($product['status']= 200){
                        ?>
                <input type="hidden" name="product_id" value="<?= $product['data']['id'] ?>">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Select Category</label>
                        <select name="category_id" class="form-select">
                            <?php
                                $categories = getAll('categories');
                                if($categories){
                                    foreach($categories as $category){
                                    ?>
                            <option value="<?= $category['id'] ?>"
                                <?=$product['data']['category_id'] == $category['id'] ?'selected':'' ?>>
                                <?= $category['name'] ?></option>
                            <?php
                                    }
                                }else{
                                    echo '<option value"">Categies not found? Ask what is wrong</option>';
                                }
                                ?>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label>Product Name *</label>
                        <input type="text" name="name" required value="<?= $product['data']['name'] ?>"
                            class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Description *</label>
                        <textarea type="text" name="description" class="form-control" rows="3">
                            <?= $product['data']['description'] ?>
                        </textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Product price *</label>
                        <input type="number" name="price" value="<?= $product['data']['price'] ?>" required
                            class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Product Quantity *</label>
                        <input type="number" name="quantity" value="<?= $product['data']['quantity'] ?>" required
                            class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Product Image *</label>
                        <input type="file" name="image" class="form-control">
                        <img src="../<?= $product['data']['image'] ?>" style="width: 200px; height:140px" alt="product">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status<i class="text-danger"> (Unchecked= visible, Checked=hidden)</i></label><br>
                        <input type="checkbox" name="status" <?= $product['data']['status'] == true ? 'checked':'' ?>
                            style="width: 30px; height: 30px">
                    </div>
                    <div class="col-md-6 mb-3 text">
                        <button name="UpdateProduct" type="submit" class="btn btn-primary float-end">Save</button>
                    </div>
                </div>
                <?php
                    }else{
                        echo '<h5>'.$product['message'].'</h5>';
                    }
                }else{
                    echo '<h5> product not found. You can not edit it yet </h5>';
                    return false;
                }
                ?>

            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>