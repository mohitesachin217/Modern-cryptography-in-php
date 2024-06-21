<?php 
// Text to be encrypted
$textToEncrypt = file_get_contents('bob.txt');

echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 1:Text to be incrypted :</br> ".$textToEncrypt;
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";

// Load public key
$publicKey = openssl_pkey_get_public(file_get_contents("public.pem"));

// Load private key
$privateKey = openssl_pkey_get_private(file_get_contents("private.pem"));


// Encrypt the text using the public key
openssl_public_encrypt($textToEncrypt, $encryptedText, $publicKey, OPENSSL_PKCS1_OAEP_PADDING);

// Encoded encrypted text for safe storage or transmission
$encodedEncryptedText = base64_encode($encryptedText);



echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 2:Encrypted Text with public key :</br> $encodedEncryptedText\n";
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";


/**
 * _+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+__
 */

// sign the message
$hash = hash('sha256',$textToEncrypt);

echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 3: Hash created from text to encrypt with hash function hash('sha256',#textToEncrypt) for signature Text :
    </br>
    You can call it as a 'Signature':
    </br>
     $hash\n
     </br>
     and hex representation of hash :</br>
     ".bin2hex($hash);
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";


// create the signature
$signature = '';
if(!openssl_private_encrypt($hash,$signature,$privateKey)){
    die('failed to sign the message'.openssl_error_string());
}

echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 4: Encrypted signature [step 3:] created with private key :</br> $signature\n";
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";


$signatureHex = bin2hex($signature);

echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 5:Hex value of the signature [step 3:] converted in hex with bin2hex():</br> $signatureHex\n";
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";

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



$fileHdd =  file_get_contents($filePath);
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 6:File converted and saved with signature attached to it:</br> $fileHdd\n";
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";



// stored file on hdd

// Encoded encrypted text
// $encodedEncryptedText = "encoded encrypted text from previous step";


// Decode the encoded encrypted text
$encryptedText = base64_decode($encodedEncryptedText);

// Decrypt the encrypted text using the private key
openssl_private_decrypt($encryptedText, $decryptedText, $privateKey, OPENSSL_PKCS1_OAEP_PADDING);

echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 7: Decrypted text with private key which is encrypted with public key in step 2 :</br> $decryptedText\n";
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";

$oHash = hash('sha256',$decryptedText);


$oSignature = '';
if(!openssl_public_decrypt($signature,$decrypted,$publicKey)){
    die('failed to verify the signature'.openssl_error_string());
}

$verificationHex = bin2hex($decrypted);



echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 8 : Hash of the decrypted text you can call it 'Signature' on receiver side :</br> $oHash\n";
echo "</br>";
echo "and hex representation of hash :</br> $verificationHex\n";
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";

 
/**
 * _+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+_+__
 */







$hashHex = bin2hex($hash);

echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 9 : Hash signature in Step 3 created with hash function hash('sha256',#textToEncrypt) for  : $hashHex\n";
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";

 

if($verificationHex == $hashHex){
    echo "</br>";
    echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
    echo "</br>";
    echo "Step 10: check the signature that is not attached to the file step 8 and step 9 verificationHex == hashHex:</br>Signature is valid:\n";
    echo "</br>";
    echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
    echo "</br>";
    echo "</br>";
    echo "</br>";

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


    echo "</br>";
    echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
    echo "</br>";
    echo "Step 11: read or recived file from source (network or HDD):</br>\n".$fileContentsWithSignature;
    echo "</br>";
    echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
    echo "</br>";
    echo "</br>";
    echo "</br>";

if ($fileContentsWithSignature === false) {
    die('Failed to read file: ' . $filePath);
}

$delimiter = "\n--SIGNATURE--\n";
list($fileContents, $signatureHex) = explode($delimiter, $fileContentsWithSignature);


echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 12: Encrypted text from file :\n".$fileContents;
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";




$encryptedText = $fileContents;

// Decode the encoded encrypted text
$encryptedText = base64_decode($encodedEncryptedText);

// Decrypt the encrypted text using the private key
openssl_private_decrypt($encryptedText, $decryptedText, $privateKey, OPENSSL_PKCS1_OAEP_PADDING);
 
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 12: Decrypted Text writter in file: :</br>\n".$decryptedText;
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";


echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 13: signature of the attched with file in hex :\n".$signatureHex;
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";


// Convert the signature from hexadecimal to binary
$signature = hex2bin($signatureHex);



echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 14: signature converted back to bin with hex2bin() :</br>\n".$signature;
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";



$oHash = hash('sha256',$decryptedText);
 
if(!openssl_public_decrypt($signature, $decrypted, $publicKey)){
    echo 'failed to verify the signature'.openssl_error_string();
}

echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 14: signature decrypted :</br>\n".$decrypted;
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";
 
$verificationHex = bin2hex($decrypted);
echo "<br/>";

echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "Step 15: Hex representation of the decrypted signature :</br>\n".$verificationHex;
echo "</br>";
echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
echo "</br>";
echo "</br>";
echo "</br>";

$hashHex = bin2hex($hash);
if($verificationHex == $hashHex){
    echo "</br>";
    echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
    echo "</br>";
    echo "Step 16: Verify the signature to check if tampering is done or not verificationHex == hashHex :</br>signature is valid for stored file";
    echo "</br>";
    echo "_+_+_+_++_+_+_+_+_+_+_+_+_+_+_+_++_+_\n";
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "<br/>";
    echo "<br/>";
}else{
    echo "problem";
}

/**
 * _=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
 */


?>
