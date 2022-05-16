<?php
    // Include config file
    require_once "config.php";
    require_once "run_model.php";
    require_once "generate_report.php";
    require_once "mail.php";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $password = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,8);

    echo $name;
    echo $email;
    echo $phone;
    echo $address;
    echo $age;
    echo $gender;

    // die();

    $sql = "SELECT * FROM patients WHERE email = '$email';";

    $result = $mysqli->query($sql);
    
    $row = $result->fetch_row();

    if ($row) {
        // Already registered
        echo "hi";
        $id = $row[0];
        $password = $row[7];
    }
    else {
        echo "hello";
        $sqlRegUser = "INSERT INTO patients (name, email, phone, address, age, gender, password) VALUES ('$name', '$email', '$phone', '$address', '$age', '$gender', '$password');";
        $mysqli->query($sqlRegUser);
        $sql = "SELECT * FROM patients WHERE email = '$email';";
        $result = $mysqli->query($sql);
        $row = $result->fetch_row();
        $id = $row[0];
    }



    $current_datetime = date('Y-m-d H:i:s');
    $current_date = date('d-m-Y');
   
    

    $image_url = "";
    $report_url = "";
    $result = -1;
    // $datetime = "";
    $sqlAddReport = "INSERT INTO reports (p_id, image_url, result, report_url, date_time) VALUES ('$id', '$image_url', $result, '$report_url', '$current_datetime');";
    $mysqli->query($sqlAddReport);
    $report_id = $mysqli->insert_id;


    // --------------------------------------------------------------


    // xray image upload

    $target_dir = "xray_images/";
    echo '<pre>'; print_r($_FILES); echo '</pre>';
    $target_file = $target_dir . $report_id . '.jpeg';
    echo $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    // if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    echo "yes";
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // }
    // else {
        // echo "no submit";
    // }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
        echo "Sorry, there was an error uploading your file." . $temp;
        }
    }


    // -----------------------------------------------------------------


    // -----------------------------------------------------------------


    $result = -1;

    // run_model.php

    // $image_url = "https://firebasestorage.googleapis.com/v0/b/agastya-2021.appspot.com/o/1.jpeg?alt=media&token=2cc16723-8efb-4351-b57f-485c3a426a1f";
    
    $image_url = 'https://ritikkanotra.000webhostapp.com/agastya/' . $target_file;
    
    
    
    
    $model_result = run_model($image_url);
    
    echo $model_result;

    if ($model_result === 'Covid19 Positive') {
        $result = 1;
    }
    else if ($model_result === 'Covid19 Negative') {
        $result = 0;
    }
    else {
        $result = 3;
    }


    // ----------------------------------------------------

    


    // -----------------------------------------------------------



    // generate_report.php

    $hospital_id = "HP00001";
    $hospital_name = "The Panacea Hospital";
    $hospital_email = "info@panacea.in";
    
    $result_bool_string = "";
    if ($result === 1) {
        $result_bool_string = 'True';
    }
    else {
        $result_bool_string = 'False';
    }

    $report_url = generate_report($report_id, $current_date, $id, $name, $email, $phone, $address, $age, $gender, $hospital_id, $hospital_name, $hospital_email, $result_bool_string);

    // $report_url = 'http://www.africau.edu/images/default/sample.pdf';
    echo '<b>'.$report_url.'</b>';
  
    // --------------------------------------------------------------


    $file_name = 'reports_pdf/' . $report_id . '.pdf';
    if (file_put_contents($file_name, file_get_contents($report_url)))
    {
        echo "File downloaded successfully";
    }
    else
    {
        echo "File downloading failed.";
    }

    $report_url = 'https://ritikkanotra.000webhostapp.com/agastya/'. $file_name;

    $sqlAddReportUrl = "UPDATE reports SET report_url = '$report_url', image_url = '$image_url', result = $result WHERE id = '$report_id';";
    $mysqli->query($sqlAddReportUrl);



    // ----------------------------------------------------------------

    // send mail

    $subject_mail = 'Report generated for patient: ' . $name;
    $message_mail = 'Login to Agastya using following credentials: <br><br>' . 'Patient Id: ' . $id . '<br>' . 'Email: ' . $email . '<br>' . 'Password: ' . $password;


    sendMail($email, $subject_mail, $message_mail);



    // ----------------------------------------------------------------


    $mysqli->close();



?>