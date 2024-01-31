<?php

require '../config/functions.php';
$paramResults = getParamId('id');
if(is_numeric($paramResults)){
    $categoryId = validate($paramResults);
    $category = getById('categories', $categoryId);
    if($category['status'] == 200){
        $categoryDelete = delete('categories', $categoryId);
        if($categoryDelete){
            redirect('categories.php', 'Category Deleted Successfully');
        }else{
            redirect('categories.php', 'Something went wrong');
        }
    }else{
        redirect('categories.php', $category['message']);
    }
}else{
    redirect('categories.php', 'the users data seem to be corrupted');
}