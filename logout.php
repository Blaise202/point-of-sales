<?php

require './config/functions.php';

if(isset($_SESSION['loggedIn'])){
    loggoutSession();
    redirect('login.php','Logged Out Sucessfully');
}