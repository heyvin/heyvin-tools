<?php

require($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
$s3 = Aws\S3\S3Client::factory(array(
                                    'credentials' => array(
                                        'key'    => '',
                                        'secret' => '',
                                        )
                            ));
$bucket = 'heyvin-us';

if(isset($_POST["name"]) && $_POST["name"] != "") {
    
    $name = $_POST['name'];
    $return = $_POST;
    
    // Get file content from Amazon S3
    try {
        $object = $s3->getObject(array(
            'Bucket' => $bucket,
            'Key' => 'tools-data/json/' . $name . '.json'
        ));
        $return["content"] = (string) $object['Body'];
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
    }
    
    echo json_encode($return);
}

?>
