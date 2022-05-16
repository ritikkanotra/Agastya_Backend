<?php

    require_once "config.php";

    $id = $_POST['id'];

    $sqlGetReports = "SELECT * FROM reports WHERE p_id = $id ORDER BY id DESC";
    
    $result = $mysqli->query($sqlGetReports);

    // echo print_r($result);

    $reports = array();

    // $i = 0;

    while ($row = $result->fetch_row()) {
        $reports[] = array(
            'id' => $row[0],
            'p_id' => $row[1],
            'image_url' => $row[2],
            'result' => $row[3],
            'report_url' => $row[4],
            'date_time' => $row[5]
        );
        // $i = $i + 1;
        // array_push($reports, $report);
    }

    echo json_encode($reports);

?>