<?php

require '../config/functions.php';
$paramResults = getParamId('id');
if(is_numeric($paramResults)){
    $adminId = validate($paramResults);
    $admin = getById('admins', $adminId);
    if($admin['status'] == 200){
        $adminDelete = delete('admins', $adminId);
        if($adminDelete){
            redirect('admins.php', 'Admin deleted Successfully');
        }else{
            redirect('admins.php', 'Something went wrong');
        }
    }else{
        redirect('admins.php', $admin['message']);
    }
}else{
    redirect('admins.php', 'the users data seem to be corrupted');
}