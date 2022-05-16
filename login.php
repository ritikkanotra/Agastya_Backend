<?php
    // Include config file
    require_once "config.php";

    $username = $_POST['uname'];
    $password = $_POST['pwd'];

    $sql = "SELECT * FROM patients WHERE id = '$username' or email = '$username';";

    $result = $mysqli->query($sql);
    
    $row = $result->fetch_row();

    if ($row) {
        // echo json_encode($row);
        if ($password === $row[7]) {
            echo json_encode(array('status'=>'1', 'id'=>$row[0]));
        }
        else {
            echo json_encode(array('status'=>'-1'));
        }
    }
    else {
        echo json_encode(array('status'=>'0'));
    }

    $mysqli->close();



?>