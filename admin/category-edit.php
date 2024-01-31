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
                <?php
                $paramValue = getParamId('id');
                if(!is_numeric($paramValue)){
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;
                }
                $category = getById('categories',$paramValue);
                if($category['status'] == 200){
                ?>
                <div class="row">
                    <input type="hidden" name="category_id" value="<?= $category['data']['id'] ?>">
                    <div class="col-md-12 mb-3">
                        <label>Name *</label>
                        <input type="text" name="name" value="<?= $category['data']['name'] ?>" required
                            class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Description *</label>
                        <textarea type="text" name="description" required class="form-control"
                            rows="3"><?= $category['data']['description'] ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status<i class="text-danger"> (Unchecked= visible, Checked=hidden)</i></label><br>
                        <input type="checkbox" name="status" <?= $category['data']['status'] == true ? 'checked':'' ?>
                            style="width: 30px; height: 30px">
                    </div>
                    <div class="col-md-6 mb-3 text">
                        <button name="UpdateCategory" type="submit" class="btn btn-primary float-end">Update</button>
                    </div>
                </div>
                <?php
                }else{
                    echo '<h5>'.$category['message'].'</h5>';
                }
                ?>
            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>