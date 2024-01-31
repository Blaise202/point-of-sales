<?php
session_start();

require 'dbconn.php';

// Input validation
function validate($inputData){
    global $conn;
    $validateData = mysqli_real_escape_string($conn, $inputData);
    return trim($validateData);
}

// Redirection
function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('Location:'.$url);
    exit(0);
}

function alertMessage(){
    if(isset($_SESSION['status'])){
        echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h6>'.$_SESSION['status'].'</h6>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        unset($_SESSION['status']); 
    }
}

// Inserting data in a table
function insert($tableName, $data){
    global $conn;
    $table = validate($tableName);
    $columns = array_keys($data);
    $values = array_values($data);
    $finalColumn = implode(',',$columns);
    $finalValues = "'".implode("','", $values)."'";
    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)"; 
    $result = mysqli_query($conn, $query);
    return $result;
}
// Updeting table data 
function update($tableName, $id, $data){
    global $conn; 
    $table = validate($tableName);
    $id = validate($id);
    $updateDataString = "";
    foreach($data as $column => $value){
        $updateDataString .= $column.'='."'$value',";
    }
    $finalUpdateData = substr(trim($updateDataString),0,-1);
    $query = "UPDATE $table SET $finalUpdateData WHERE id = '$id';";
    $result = mysqli_query($conn, $query);
    return $result;
}

function getAll($tableName, $status=null){
    global $conn;
    $table = validate($tableName);
    $status = validate($status);
    if($status == 'status'){
        $query = "SELECT * FROM $table WHERE status = '0'";
    }
    else{
        $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn, $query);
}

function getById($tableName, $id){
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if($result){
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data'=>$row,
                'message' => 'Data found'
            ];
            return $response;

        }else{
        $response = [
            'status' => 404,
            'message' => 'No Data Found'
        ];
        return $response;
    }
    }else{
        $response = [
            'status' => 500,
            'message' => 'something went wrong'
        ];
        return $response;
    }
} 

function delete($tableName, $id){
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "DELETE FROM $table WHERE id= '$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function getParamId($type){
    if(isset($_GET[$type])){
        if($_GET[$type]!=''){
            return $_GET[$type];
        }else{
            return '<h5>No Id Found</h5>';
        }
    }else{
        return '<h5>NO Id Given</h5>';
    }
}

function loggoutSession(){
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

function jsonResponse($status, $status_type, $message){
    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message
    ];
    echo json_encode($response);
    return;
}

function getcounts($tableName){
    global $conn ;
    $table = validate($tableName);
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;
    }else{
        return '<h5>Database Connection Failed</h5>';
    }
}