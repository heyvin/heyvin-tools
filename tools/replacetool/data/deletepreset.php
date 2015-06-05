<?php

require($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
$s3 = Aws\S3\S3Client::factory(array(
                                    'credentials' => array(
                                        'key'    => 'AKIAIRRHXXT474LBNQ2Q',
                                        'secret' => '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',
                                        )
                            ));
$bucket = 'heyvin-us';

if(isset($_POST["name"]) && $_POST["name"] != "") {
    
    $name = $_POST['name'];
    $return = $_POST;
    
    // Delete from Amazon S3
    try {
        $object = $s3->deleteObject(array(
            'Bucket' => $bucket,
            'Key' => 'tools-data/json/' . $name . '.json'
        ));
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
    }
    
    echo json_encode($return);
}

?>