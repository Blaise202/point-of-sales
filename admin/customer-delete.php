<?php

require '../config/functions.php';
$paramResults = getParamId('id');
if(is_numeric($paramResults)){
    $customerId = validate($paramResults);
    $customer = getById('customers', $customerId);
    if($customer['status'] == 200){
        $customerDelete = delete('customers', $customerId);
        if($customerDelete){
            redirect('customers.php', 'customer Deleted Successfully');
        }else{
            redirect('customers.php', 'Something went wrong');
        }
    }else{
        redirect('customers.php', $customer['message']);
    }
}else{
    redirect('customers.php', 'the users data seem to be corrupted');
}