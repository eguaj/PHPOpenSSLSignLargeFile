<?php

function openssl_sign_large_file($file, &$signature, $privKeyFile) {
	$digest = sha1_file($file, true);

	$asn1  = chr(0x30).chr(0x21); // SEQUENCE, 33
	$asn1 .= chr(0x30).chr(0x09); // SEQUENCE, 9
	$asn1 .= chr(0x06).chr(0x05); // OBJECT IDENTIFIER, 5
	$asn1 .= chr(0x2b).chr(0x0e).chr(0x03).chr(0x02).chr(0x1a); // 1.3.14.3.2.26 (SHA1)
	$asn1 .= chr(0x05).chr(0x00); // NULL
	$asn1 .= chr(0x04).chr(0x14); // OCTET STRING, 20
	$asn1 .= $digest;

	if (is_resource($privKeyFile)) {
		$privKey = $privKeyFile;
	} else {
		$privKey = openssl_pkey_get_private(file_get_contents($privKeyFile));
		if ($privKey === false) {
			return false;
		}
	}
	return openssl_private_encrypt($asn1, $signature, $privKey);
}

function openssl_verify_large_file($file, $signature, $pubKeyFile) {
	$digest = sha1_file($file, true);

	if (is_resource($pubKeyFile)) {
		$pubKey = $pubKeyFile;
	} else {
		$pubKey = openssl_pkey_get_public(file_get_contents($pubKeyFile));
		if ($pubKey === false) {
			return false;
		}
	}
	openssl_public_decrypt($signature, $asn1, $pubKey);

	$decrypted_digest = substr($asn1, 15); // Blindly strip the ASN1 header

	if( $digest == $decrypted_digest ) {
		return true;
	}

	return false;
}

