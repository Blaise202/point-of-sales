<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Customers
                <a href="customer-create.php" class="btn btn-primary float-end">Add customer</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>
            <?php $customers=getAll('customers');
            if(!$customers){
                echo '<h4>Error happened in fetching data!</h4>';
            }
            if(mysqli_num_rows($customers)>0){
                ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach( $customers as $customer):?>
                    <tbody>

                        <tr>
                            <td><?=$customer['id']?></td>
                            <td><?=$customer['name']?></td>
                            <td><?=$customer['email']?></td>
                            <td><?=$customer['phone']?></td>
                            <td>
                                <?php
                                if($customer['status'] == '1'){
                                    echo '<span class="badge bg-danger ">Hidden</span>';
                                }else{
                                    echo '<span class="badge bg-primary">Visible</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="customer-edit.php?id=<?= $customer['id'] ?>" class="btn btn-success ">Edit</a>
                                <a href="customer-delete.php?id=<?= $customer['id'] ?>" class="btn btn-danger "
                                    onclick="return confirm('Are you sure you are deleting this Customer?')">Delete</a>
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