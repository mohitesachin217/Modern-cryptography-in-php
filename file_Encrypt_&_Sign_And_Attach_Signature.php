<?php 
// Text to be encrypted
$textToEncrypt = file_get_contents('bob.txt');

// Load public key
$publicKey = openssl_pkey_get_public(file_get_contents("public_key.pem"));

// Load private key
$privateKey = openssl_pkey_get_private(file_get_contents("private_key.pem"));


// Encrypt the text using the public key
openssl_public_encrypt($textToEncrypt, $encryptedText, $publicKey, OPENSSL_PKCS1_OAEP_PADDING);

// Encoded encrypted text for safe storage or transmission
$encodedEncryptedText = base64_encode($encryptedText);

echo "Encrypted Text: $encodedEncryptedText\n";


/**
 * _+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+__
 */
// sign the message
$hash = hash('sha256',$textToEncrypt);
// create the signature
$signature = '';
if(!openssl_private_encrypt($hash,$signature,$privateKey)){
    die('failed to sign the message'.openssl_error_string());
}

$signatureHex = bin2hex($signature);
echo $signatureHex.'\n';
/**
 * _+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+__
 */

 /**
 * _=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
 */
$filePath = 'signatureAttachedFile.txt';
 // Append the signature to the original file with a delimiter
$delimiter = "\n--SIGNATURE--\n";
file_put_contents($filePath, $encodedEncryptedText . $delimiter . $signatureHex);

/**
 * _=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
 */


// stored file on hdd

// Encoded encrypted text
// $encodedEncryptedText = "encoded encrypted text from previous step";


// Decode the encoded encrypted text
$encryptedText = base64_decode($encodedEncryptedText);

// Decrypt the encrypted text using the private key
openssl_private_decrypt($encryptedText, $decryptedText, $privateKey, OPENSSL_PKCS1_OAEP_PADDING);
echo "<br/>";
echo "Decrypted Text: $decryptedText\n";
echo "<br/>";
/**
 * _+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+__
 */
$oHash = hash('sha256',$decryptedText);

$oSignature = '';
if(!openssl_public_decrypt($signature,$decrypted,$publicKey)){
    die('failed to verify the signature'.openssl_error_string());
}

$verificationHex = bin2hex($decrypted);
echo "<br/>";
echo $verificationHex.'\n';
$hashHex = bin2hex($hash);
if($verificationHex == $hashHex){
    echo "<br/>";
    echo "signature is valid\n";
    echo "<br/>";
}else{
    echo "problem";
}
/**
 * _+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+__
 */


/**
 * _=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
 */

 // Separate the original file content and the signature

 // Read the file contents including the signature
$fileContentsWithSignature = file_get_contents($filePath);
if ($fileContentsWithSignature === false) {
    die('Failed to read file: ' . $filePath);
}

$delimiter = "\n--SIGNATURE--\n";
list($fileContents, $signatureHex) = explode($delimiter, $fileContentsWithSignature);

// Convert the signature from hexadecimal to binary
$signature = hex2bin($signatureHex);

$encryptedText = $fileContents;

// Decode the encoded encrypted text
$encryptedText = base64_decode($encodedEncryptedText);

// Decrypt the encrypted text using the private key
openssl_private_decrypt($encryptedText, $decryptedText, $privateKey, OPENSSL_PKCS1_OAEP_PADDING);
echo "<br/>";
echo "\nDecrypted Text: $decryptedText\n";
echo "<br/>";
$oHash = hash('sha256',$decryptedText);

$oSignature = '';
if(!openssl_public_decrypt($signature, $decrypted, $publicKey)){
    die('failed to verify the signature'.openssl_error_string());
}

$verificationHex = bin2hex($decrypted);
echo "<br/>";
echo $verificationHex.'\n';
$hashHex = bin2hex($hash);
if($verificationHex == $hashHex){
    echo "<br/>";
    echo "signature is valid for stored file\n";
    echo "<br/>";
}else{
    echo "problem";
}

/**
 * _=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
 */


?>