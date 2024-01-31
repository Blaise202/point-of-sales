<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Categories
                <a href="category-create.php" class="btn btn-primary float-end">Add Category</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>
            <?php $categories=getAll('categories');
            if(!$categories){
                echo '<h4>Error happened in fetching data!</h4>';
            }
            if(mysqli_num_rows($categories)>0){
                ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach( $categories as $category):?>
                    <tbody>

                        <tr>
                            <td><?=$category['id']?></td>
                            <td><?=$category['name']?></td>
                            <td><?=$category['description']?></td>
                            <td>
                                <?php
                                if($category['status'] == '1'){
                                    echo '<span class="badge bg-danger ">Hidden</span>';
                                }else{
                                    echo '<span class="badge bg-primary">Visible</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="category-edit.php?id=<?= $category['id'] ?>" class="btn btn-success ">Edit</a>
                                <a href="category-delete.php?id=<?= $category['id'] ?>"
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