<?php

include('../config/functions.php');

if(isset($_POST['SaveAdmin'])){
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $password = validate($_POST['password']);
    $is_ban = isset($_POST['is_ban']) == true ? 1:0;
    if($name!='' && $email!='' && $password!='' && $phone!=''){
        $checkEmail =mysqli_query($conn,"SELECT * FROM admins WHERE email='$email'");
        if($checkEmail){
            if(mysqli_num_rows($checkEmail)>0){
                redirect('admins-create.php', 'Email already occupied');
            }
        }
        $bycrypt_password = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bycrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];
        $result = insert('admins', $data);
        if($result){
            redirect('admins.php', 'Admin added Successfully');
        }else{
            redirect('admins-create.php', 'Admin not added may be something went wrong try again');
        }
    }else{
        redirect('admins-create.php', 'Please Fill in all the required fields');
    }
}

if(isset($_POST['UpdateAdmin'])){
    $adminId = validate($_POST['adminId']);
    $adminData = getById('admins', $adminId);
    if($adminData['status'] != 200){
        redirect('admin-edit.php?id='.$adminId, 'Please fill required fields.');
    }
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $password = validate($_POST['password']);
    $is_ban = isset($_POST['is_ban']) == true ? 1:0;   
    if($password != ''){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }else{
        $hashedPassword = $adminData['data']['password'];
    }
    if($name !='' && $email !=''){
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'is_ban' => $is_ban,
            'password' => $hashedPassword,
        ];
        $result = update('admins', $adminId, $data);
        if($result){
            redirect('admins.php','Admin updated successfully');
        }else{
            redirect('admin-edit.php?='.$adminId,'something went wrong');
        }
    }else{
        redirect('admins-create.php', 'Please fill the required fields');
    }
}

if(isset($_POST['SaveCategory'])){
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;
    if($name!='' ){
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ];
        $result = insert('categories', $data);
        if($result){
            redirect('categories.php', 'Category Created successfully');
        }else{
            redirect('category-create.php', 'Something Went Wrong please try again');
        }
    }else{
        redirect('category-create.php', 'Please Fill in all the required fields(*)');
    }
}

if(isset($_POST['UpdateCategory'])){
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;
    if($name!='' && $description!=''){
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ];
        $result = update('categories', $category_id, $data);
        if($result){
            redirect('categories.php', 'Category Updated successfully');
        }else{
            redirect('category-edit.php?='.$category['data']['id'], 'Something Went Wrong please try again');
        }
    }else{
        redirect('category-edit.php?='.$category['data']['id'], 'Please Fill in all the required parts(*)');
    }
}

if(isset($_POST['SaveProduct'])){

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size']> 0){
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$fileName);
        $finalImage = "assets/uploads/products/".$fileName;
    }
    else{
        $finalImage = '';
    }


    if($name!='' ){
        $data = [
            'category_id' => $category_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $finalImage,
            'status' => $status,
        ];
        $result = insert('products', $data);
        if($result){
            redirect('products.php', 'Product Created successfully');
        }else{
            redirect('product-create.php', 'Something Went Wrong please try again');
        }
    }else{
        redirect('product-create.php', 'Please Fill in all the required fields(*)');
    }
}

if(isset($_POST['UpdateProduct'])){
    $product_id = validate($_POST['product_id']);
    $productdata = getById('products', $product_id);
    if(!$productdata){
        redirect('product-edit.php', 'Product Id was not Retrieved');
    } 
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size']> 0){
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$fileName);
        $finalImage = "assets/uploads/products/".$fileName;
        $deleteOldImage = "../".$productdata['data']['image'];
        if(file_exists($deleteOldImage)){
            unlink($deleteOldImage);
        }
    }
    else{
        $finalImage = $productdata['data']['image'];
    }


    if($name!='' ){
        $data = [
            'category_id' => $category_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $finalImage,
            'status' => $status,
        ];
        $result = update('products', $product_id, $data);
        if($result){
            redirect('products.php', 'Product Updated successfully');
        }else{
            redirect('product-edit.php?='.$product['data']['id'], 'Something Went Wrong please try again');
        }
    }else{
        redirect('product-edit.php?='.$product['data']['id'], 'Please Fill in all the required fields(*)');
    }
}

if(isset($_POST['SaveCustomer'])){
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) == true ? 1:0;
    if($name!='' && $email!='' && $phone!=''){
        $checkEmail = mysqli_query($conn,"SELECT * FROM customers WHERE email= '$email' LIMIT 1");
        if(mysqli_num_rows($checkEmail) == 0){
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'status' => $status,
            ];
            $result = insert('customers', $data);
            if($result){
                redirect('customers.php', 'Customer Added successfully');
            }else{
                redirect('customers.php', 'Something Went Wrong please try again');
            }
        }else{
            redirect('customer-create.php', 'The email provided already existsin database');
        }
    }else{
        redirect('customers.php', 'Please Fill in all the required parts(*)');
    }
}

if(isset($_POST['Updatecustomer'])){
    $customer_id = validate($_POST['customer_Id']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) == true ? 1:0;
    if($name!='' && $email!='' && $phone!=''){
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
        ];
        $result = update('customers', $customer_id, $data);
        if($result){
            redirect('customers.php', 'customer Updated successfully');
        }else{
            redirect('customer-edit.php?='.$customer['data']['id'], 'Something Went Wrong please try again');
        }
    }else{
        redirect('customer-edit.php?='.$customer['data']['id'], 'Please Fill in all the required parts(*)');
    }
}