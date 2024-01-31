<?php

require './config/functions.php';
if(isset($_POST['loginBtn'])){
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    if($email !='' && $password!='' ){
        $query= "SELECT * FROM admins WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if($result){
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];
                if(!password_verify($password, $hashedPassword)){
                    redirect('login.php', 'Invalid Password');
                }
                if($row['is_ban'] == 1){
                    redirect('login.php', 'Oops!! Your account has been banned. Contact your admin');
                }
                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                ];
                redirect('admin/index.php', 'Logged in Successfully');
            }else{
                redirect('login.php', 'Invalid Email Address');
            }
        }else{
            redirect('login.php', 'Something Went Wrong. Please try again.');
        }
    }else{
        redirect('login.php', 'please fill in all the fields');
    }
}