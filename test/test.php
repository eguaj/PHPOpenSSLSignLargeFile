<?php

$DIR = dirname(__FILE__);

include_once($DIR . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'PHPOpenSSLSignLargeFile.php');

$file = __FILE__;

$signature = false;
$ret = openssl_sign_large_file($file, $signature, $DIR . DIRECTORY_SEPARATOR . 'private_key.pem');
if ($ret === false) {
	printf("Error signing file.\n");
	exit(1);
}
printf("Signature = '%s'\n", base64_encode($signature));

$ret = openssl_verify_large_file($file, $signature, $DIR . DIRECTORY_SEPARATOR . 'public_key.pem');
if ($ret === false) {
	printf("Invalid signature.\n");
	exit(1);
}
printf("Valid signature.\n");
exit(0);
