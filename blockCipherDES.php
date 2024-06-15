<?php
$data = "This is the data to encrypt";
$encryptionKey = "your-secret-key";

$iv = openssl_random_pseudo_bytes(8); // DES uses a fixed block size of 8 bytes

$ciphertext = openssl_encrypt($data, 'DES-CBC', $encryptionKey, OPENSSL_RAW_DATA, $iv);
$encryptedData = base64_encode($iv . $ciphertext);

echo "Encrypted Data: " . $encryptedData;
 
 
$encryptionKey = "your-secret-key";

$encryptedData = base64_decode($encryptedData);
$iv = substr($encryptedData, 0, 8); // Extract the IV (8 bytes for DES)
$ciphertext = substr($encryptedData, 8); // The rest is the actual ciphertext

$originalData = openssl_decrypt($ciphertext, 'DES-CBC', $encryptionKey, OPENSSL_RAW_DATA, $iv);

echo "Original Data: " . $originalData;
?>

