<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Admins/staff
                <a href="admins-create.php" class="btn btn-primary float-end">Add admin</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>
            <?php $admins=getAll('admins');
            if(!$admins){
                echo '<h4>Error happened in fetching data!</h4>';
            }
            if(mysqli_num_rows($admins)>0){
                ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Is Ban</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach( $admins as $admin):?>
                    <tbody>

                        <tr>
                            <td><?=$admin['id']?></td>
                            <td><?=$admin['name']?></td>
                            <td><?=$admin['email']?></td>
                            <td>
                                <?php
                                if($admin['is_ban'] == '0'){
                                    echo'<span class="badge bg-primary">Active</span>';
                                }else{
                                    echo '<span class="badge bg-danger">Banned</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="admin-edit.php?id=<?= $admin['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="admin-delete.php?id=<?= $admin['id'] ?>"
                                    class="btn btn-danger btn-sm">Delete</a>
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