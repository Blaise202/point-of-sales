<?php

require '../config/functions.php';

$paramResults = getParamId('index');
if(is_numeric($paramResults)){
    $indexValue = validate($paramResults);
    if(isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])){
        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);
        redirect('order-create.php', 'Order Removed successfully');
    }else{
        redirect('order-create.php', 'no Item found');
    }
}else{
    redirect('order-create.php', 'Id parameter is not a numnber');
}