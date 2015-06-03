<?php

require('vendor/autoload.php');

use Aws\S3\S3Client;
$s3 = Aws\S3\S3Client::factory();
$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');

$name = $_POST['name'];
$json = $_POST['json'];

$return = $_POST;

if ($name != null && json_decode($json) != null) {
    
//    try {
//        // FIXME: do not use 'name' for upload (that's the original filename from the user's computer)
//        $upload = $s3->upload($bucket, $_FILES['userfile'][$name . '.json'], fopen($_FILES['userfile']['tmp_name'], 'rb'), 'public-read');
//   } catch(Exception $e) {
//        $return["result"] = "ng";
//    }

    // Upload an object to Amazon S3
    $result = $s3->putObject(array(
        'Bucket' => $bucket,
        'Key'    => $name . '.json',
        'Body'   => $json,
        'ACL'    => 'public-read'
    ));
    
//    $file = fopen($name . '.json','w+');
//    fwrite($file, $json);
//    fclose($file);
    $return["path"] = $result['ObjectURL'];
    $return["result"] = "ok";
} else {
    $return["result"] = "ng";
}

echo json_encode($return);
    
?>