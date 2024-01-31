<?php
require '../config/functions.php';

if(!isset($_SESSION['productItems'])){
    $_SESSION['productItems']= [];
}

if(!isset($_SESSION['productItemIds'])){
    $_SESSION['productItemIds']= [];
}

if(isset($_POST['AddItem'])){
    $product_id = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);
    if($product_id!='' && $quantity!=''){
        $chekProductId = "SELECT * FROM products WHERE id = '$product_id'";
        if($chekProductId){
            $result = mysqli_query($conn, $chekProductId);
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                if($row['quantity'] >= $quantity){
                    $data = [
                        'product_id' => $row['id'],
                        'name' => $row['name'],
                        'image' => $row['image'],
                        'price' => $row['price'],
                        'quantity' => $quantity,
                    ];
                    if(!in_array($row['id'],$_SESSION['productItemIds'])){
                        array_push($_SESSION['productItemIds'],$row['id']);
                        array_push($_SESSION['productItems'],$data);
                    }else{
                        foreach($_SESSION['productItems'] as $key=>$prodSessionItem);
                        if($prodSessionItem['product_id'] == $row['id']){
                            $newQuantity = $prodSessionItem['quantity'] + $quantity;
                            $data = [
                                'product_id' => $row['id'],
                                'name' => $row['name'],
                                'image' => $row['image'],
                                'price' => $row['price'],
                                'quantity' => $newQuantity,
                            ];
                            $_SESSION['productItems'][$key] = $data ;
                        }
                    }
                    redirect('order-create.php', 'item added '.$row['name']);
                }else{
                    redirect('order-create.php', '<i class="text-danger">The amount you ordered exceeds the available! You can order atmost '.$row['quantity'].' ' .$row['name'].'s.</i>' );
                }
            }
        }else{
            redirect('order-create.php', 'Eventually, A product is currently unavailable.');
        }
    }else{
        redirect('order-create.php', 'All fields need to be filled');
    }
}

if(isset($_POST['productIncDec'])){
    $product_id = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);
    $flag = false;
    foreach ($_SESSION['productItems'] as $key => $item) {
        if($item['product_id'] == $product_id){
            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }
    if($flag){
        jsonResponse(200, 'success', 'Quantity Updated');
    }else{
        jsonResponse(500, 'error', 'Something went Wrong! Please re-try');
    }
}

if(isset($_POST['proceedToPlaceBtn'])){
    $cphone = validate($_POST['cphone']);
    $payment_mode = validate($_POST['payment_mode']);
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$cphone' LIMIT 1");
    if($checkCustomer){
        if(mysqli_num_rows($checkCustomer)>0){
            $_SESSION['invoice_no'] = 'INV-'.rand(11111,999999);
            $_SESSION['cphone'] =$cphone;
            $_SESSION['payment_mode'] =$payment_mode;
            jsonResponse(200, 'success', 'The customer found');
        }else{
            $_SESSION['cphone'] =$cphone;
            jsonResponse(404, 'warning', 'The customer phone number provided is not in our database');
        }
    }else{
        jsonResponse(500, 'error', 'The connection to the database failed Please re-try');
    }
}

if(isset($_POST['saveCustomerBtn'])){
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);
    if($name!='' && $phone!=''){
        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
        ];
        $result = insert('customers', $data);
        if($result){
            jsonResponse(200,'success','Customer added successfully');
        }else{
            jsonResponse(500, 'error', 'An error occured! Please re-try to add a customer');
        }
    }else{
        jsonResponse(404, 'error', 'Name and Email are required');
    }
}

if(isset($_POST['saveOrder'])){
    $phone = validate($_SESSION['cphone']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
    if($checkCustomer){
        if(mysqli_num_rows($checkCustomer)>0){
            $customerData = mysqli_fetch_assoc($checkCustomer);
            if(!isset($_SESSION['productItems'])){
                jsonResponse(404,'warning','No items found');
            }
            $sessionProduct = $_SESSION['productItems'];
            $totalAmount = 0;
            foreach($sessionProduct as $amount){
                $totalAmount += $amount['price'] * $amount['quantity'];
            }
            $data = [
                'customer_id' => $customerData['id'],
                'tracking_no' => rand(11111,999999),
                'invoice_no' => $invoice_no,
                'totalAmount' => $totalAmount,
                'order_date' =>date('Y-m-d'),
                'order_status' => 'booked',
                'payment_mode' => $payment_mode,
                'order_placed_by_id'=> $order_placed_by_id
            ];
            $result = insert('orders', $data);
            $lastOrderId = mysqli_insert_id($conn);
            foreach($sessionProduct as $productItem){
                $productId = $productItem['product_id'];
                $price = $productItem['price'];
                $quantity = $productItem['quantity'];
                $dataOrderItem = [
                    'order_id' => $lastOrderId,
                    'product_id' => $productId,
                    'price' => $price,
                    'quantity' => $quantity,
                ];
                $orderItemQuery = insert('order_items' , $dataOrderItem);
                $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
                $productQuantityData = mysqli_fetch_assoc($checkProductQuantityQuery);
                $totalProductQuantity = $productQuantityData['quantity']-$quantity;
                $upadteData = [
                    'quantity' => $totalProductQuantity, 
                ];
                $updateProductQuantity = update('products', $productId, $upadteData);
            }
            unset($_SESSION['productItemIds']);
            unset($_SESSION['productItems']);
            unset($_SESSION['cphone']);
            unset($_SESSION['payment_mode']);
            unset($_SESSION['invoice_no']);
            jsonResponse(200, 'success', 'Order Placed Successfully');
        }else{
            jsonResponse(404, 'warning', 'Customer Not Found');
        }
    }else{
        jsonResponse(500, 'error','Connection to the database failed.  Please re-try');
    }
}