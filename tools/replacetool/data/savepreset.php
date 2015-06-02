<?php

    $name = $_POST['name'];
    $json = $_POST['json'];

    $return = $_POST;

    if ($name != null && json_decode($json) != null) {
        $file = fopen($name . '.json','w+');
        fwrite($file, $json);
        fclose($file);
        $return["result"] = "ok";
    } else {
        $return["result"] = "ng";
    }
    
    echo json_encode($return);
    
?>