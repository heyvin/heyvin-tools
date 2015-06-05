<?php

require($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
$s3 = Aws\S3\S3Client::factory(array(
                                    'credentials' => array(
                                        'key'    => 'AKIAIRRHXXT474LBNQ2Q',
                                        'secret' => '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',
                                        )
                            ));
$bucket = 'heyvin-us';

$name = $_POST['name'];
$json = $_POST['json'];
$return = $_POST;

if ($name != null && json_decode($json) != null) {

    // Upload an object to Amazon S3
    try {
        $result = $s3->putObject(array(
            'Bucket' => $bucket,
            'Key'    => 'tools-data/json/' . $name . '.json',
            'Body'   => $json,
            'ACL'    => 'public-read'
        ));
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
    }
    
    $return["path"] = $result['ObjectURL'];
    $return["result"] = "ok";
} else {
    $return["result"] = "ng";
}

echo json_encode($return);
    
?>