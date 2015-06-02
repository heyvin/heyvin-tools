<?php

    if(isset($_POST["name"]) && $_POST["name"] != "") {
        $content = file_get_contents($_POST["name"] . ".json");
        $return = $_POST;
        $return["content"] = $content;
        echo json_encode($return);
    }

?>