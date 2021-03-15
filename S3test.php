<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$bucket = 'kameishuta';
$keyname = 'S3test';

$s3 = new S3Client([
   'version' => 'latest',
   'region'  => 'ap-northeast-1'
]);

try {
   // Upload data.
   $result = $s3->putObject([
       'Bucket' => $bucket,
       'Key'    => $keyname,
       'Body'   => 'Hello, world!',
       'ACL'    => 'public-read'
   ]);

   // Print the URL to the object.
   echo $result['ObjectURL'] . PHP_EOL;
} catch (S3Exception $e) {
   echo $e->getMessage() . PHP_EOL;
} 
