<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin
                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <?php
                if(isset($_GET['id'])){
                    if($_GET['id'] != ''){
                        $adminId = $_GET['id'];
                    }else{
                        echo '<h5>No Id Found</h5>';
                        return false;
                    }
                }else{
                    echo '<h5>No Id given in the params</h5>';
                    return false;
                }
                $adminData = getById('admins', $adminId);
                if($adminData){
                    if($adminData['status'] == 200){
                    ?>
                <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>" id="">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" value="<?= $adminData['data']['name']; ?>" required
                            class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Email *</label>
                        <input type="email" name="email" value="<?= $adminData['data']['email']; ?>" required
                            class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Password *</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Phone number *</label>
                        <input type="number" name="phone" value="<?= $adminData['data']['phone']; ?>" required
                            class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Is Ban</label>
                        <input type="checkbox" name="is_ban"
                            value="<?= $adminData['data']['name'] == true? 'checked':'' ; ?>"
                            style="width: 30px; height: 30px">
                    </div>
                    <div class="col-md-3 mb-3">
                        <button name="UpdateAdmin" type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php
                    }else{
                        echo '<h5>'.$adminData['message'].'</h5>';
                    }
                }else{
                    echo '<h5>Error happened in fetching data</h5>';
                    return false;
                }
                ?>

            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>