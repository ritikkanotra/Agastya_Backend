<?php


    function run_model($image_url) {

        $data = array(
            'image_url' => $image_url
        );


        $postvars = http_build_query($data) . "\n";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://66df-47-8-45-217.in.ngrok.io/predict');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        // echo 'server output: ' . $server_output;

        echo $server_output;

        $data = json_decode($server_output);

        echo '<pre>'; print_r($data); echo '</pre>';

        curl_close ($ch);

        return $data->type;

        // echo print_r($data);

        
    }

?>