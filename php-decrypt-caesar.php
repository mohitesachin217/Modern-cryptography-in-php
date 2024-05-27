<?php 
/**
 * 
 * Generate caser cipher key 
 * 
 */
function generate_key($n)
{
    $letters = explode(' ',"A B C D E F G H I J K L M N O P Q R S T U V W X Y Z");
    $key = [];
    $cnt = 0;

    foreach($letters as $index => $letter)
    {
        $key[$letter] = $letters[($index + $n) % count($letters)];
    }
        
    return $key;
}

/**
 * 
 * Get decryption key caeser cipher
 * 
 */

function get_decryption_key($key){
    $dkey=[];
    foreach($key as $letter){
        $dkey[$key[$letter]] = $letter;
    }
    return $dkey;
}

/**
 * 
 * Encrypt message using caeser cipher
 * 
 */
function encrypt($encrypt_key,$msg)
{
    $message = str_split($msg);
    $cipher = '';
    foreach($message as $index => $msg_value){
        if(array_key_exists($msg_value,$encrypt_key))
        {
            $cipher .= $encrypt_key["$msg_value"];
        }else{
            $cipher .= $msg_value;
        }
    }
    return $cipher;
}

$message = "YOU ARE AWESOME";
$key = generate_key(3);
$message = encrypt($key,$message);
echo $message;


$i=1;
while($i){
    $dkey = generate_key($i);
    $dMessage = encrypt($dkey, $message);
    echo '<br/>'.$i.'='.$dMessage;
    if($i == 26){
        break;
    }
    $i++;
}

?>
