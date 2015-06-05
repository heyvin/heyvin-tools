<?php

require($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
$s3 = Aws\S3\S3Client::factory(array(
                                    'credentials' => array(
                                        'key'    => 'AKIAIRRHXXT474LBNQ2Q',
                                        'secret' => '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',
                                        )
                            ));
$bucket = 'heyvin-us';

$return = $_POST;

// Get file list from Amazon S3
try {
    $objects = $s3->getIterator('ListObjects', array(
        'Bucket' => $bucket,
        'Prefix' => 'tools-data/json/'
    ));
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}

$files = [];
foreach ($objects as $object) {
    array_push($files, $object['Key']);
}

$return["files"] = $files;
echo json_encode($return);

?>