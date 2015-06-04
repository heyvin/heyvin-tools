<?php

require($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');

// AKIAIRRHXXT474LBNQ2Q
// xinimOEjZFhSCkoE8bdNyH61WnoymZD5ILfdqmkg
$key = getenv('AWS_ACCESS_KEY_ID');
$secret = getenv('AWS_SECRET_ACCESS_KEY');
$s3 = Aws\S3\S3Client::factory(array(
                                    'credentials' => array(
                                        'key'    => $key,
                                        'secret' => $secret,
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
            'Key'    => $name . '.json',
            'Body'   => $json,
            'ACL'    => 'public-read'
        ));
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
    }
    
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