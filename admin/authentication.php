<?php

if(isset($_SESSION['loggedIn'])){
    $email = validate($_SESSION['loggedInUser']['email']);
    $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
    if($query){
        $result = mysqli_query($conn, $query);
        if($result){
            if(mysqli_num_rows($result) == 0){
                loggoutSession();
                redirect('../login.php','access danied');
            }else{
                $row = mysqli_fetch_assoc($result);
                if($row['is_ban'] == 1){
                    redirect('../login.php','Your account has been banned. Please contact your Admin');
                }
            }
        }else{
            redirect('../login.php','Database Connection failed');
        }
    }else{redirect('../login.php', 'something went wrong');}
}else{
    redirect('../login.php', 'Login First to continue...');
}