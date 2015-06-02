<?php

    $files = glob("*.json");
    $return = $_POST;
    $return["files"] = $files;
    echo json_encode($return);

?>