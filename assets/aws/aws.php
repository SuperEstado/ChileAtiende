<?php
require_once('S3.php');

$mysqldump_location='/usr/local/bin/mysqldump';
$backup_location='/home/transparencia/';
$dbhost='localhost';
$dbname='chileatiende';
$dbuser='root';
$dbpass='';


//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJKMXGWRMKJ3QB4MQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');

//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

//create a new bucket
//$s3->putBucket("chileatiende", S3::ACL_PRIVATE);



$backupName=$dbname . date("Y-m-d-H-i-s") . '.gz';
$backupFile = $backup_location.'/'.$backupName;
$command = $mysqldump_location." -h $dbhost -u $dbuser -p$dbpass $dbname | gzip > $backupFile";
system($command);



//move the file
if ($s3->putObjectFile($backupFile, "chileatiende", $backupName, S3::ACL_PRIVATE)) {
    echo "Se subio el archivo con exito.";
}else{
    echo "Algo fallo al subir el archivo.";
}  

