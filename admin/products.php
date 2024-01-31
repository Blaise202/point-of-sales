<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="product-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>
            <?php $products=getAll('products');
            if(!$products){
                echo '<h4>Error happened in fetching data!</h4>';
            }
            if(mysqli_num_rows($products)>0){
                ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach( $products as $product):?>
                    <tbody>

                        <tr>
                            <td><?=$product['id']?></td>
                            <td>
                                <img src="../<?= $product['image']?>" style="width: 60px; height: 50px;" alt="Product">
                            </td>
                            <td><?=$product['name']?></td>
                            <td><?=$product['description']?></td>
                            <td>
                                <?php
                                if($product['status'] == '1'){
                                    echo '<span class="badge bg-danger ">Hidden</span>';
                                }else{
                                    echo '<span class="badge bg-primary">Visible</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="product-edit.php?id=<?= $product['id'] ?>" class="btn btn-success ">Edit</a>
                                <a href="product-delete.php?id=<?= $product['id'] ?>"
                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                    class="btn btn-danger ">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach?>
                </table>
            </div>
            <?php
            }else{
            ?>
            <h4 class="mb-0">No Record Found</h4>
            <?php } ?>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>