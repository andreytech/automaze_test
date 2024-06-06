<?php
$encrypted_data = "OtSrzlB7n3MjD01XlzM4MfNeam1Z-oCnO3kEkxptuS4";
$encryption_key = md5('automaze');

$encrypted_data = base64_decode($encrypted_data);

$iv_length = openssl_cipher_iv_length('aes-256-cbc');
$iv = substr($encrypted_data, 0, $iv_length);
$encrypted_string = substr($encrypted_data, $iv_length);

$decrypted = openssl_decrypt($encrypted_string, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);

echo "Decrypted: " . $decrypted . "\n";