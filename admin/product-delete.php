<?php

require '../config/functions.php';
$paramResults = getParamId('id');
if(is_numeric($paramResults)){
    $productId = validate($paramResults);
    $product = getById('products', $productId);
    if($product['status'] == 200){
        $productDelete = delete('products', $productId);
        if($productDelete){
            $deleteImage = '../'.$product['data']['image'];
            if(file_exists($deleteImage)){
                unlink($deleteImage);
            }
        }
        if($productDelete){
            redirect('products.php', 'product Deleted Successfully');
        }else{
            redirect('products.php', 'Something went wrong. A product was not deleted');
        }
    }else{
        redirect('products.php', $product['message']);
    }
}else{
    redirect('products.php', 'the users data seem to be corrupted');
}