<?php

class KeyStream {
    private $next;
    
    public function __construct($key = 1) {
        $this->next = $key;
    }

    /**
    * Linear congruential generator is used to generate a sequence of pseudo-random numbers.
    * It is an implementation of a linear congruential generator (LCG), which is one of the oldest and simplest algorithms 
    * for generating pseudo-random numbers.
    */
    private function rand() {
        $this->next = (1103515245 * $this->next + 12345) % (2 ** 31);
        return $this->next;
    }
    
    public function getKeyByte() {
        return $this->rand() % 256;
    }
}

function encrypt($key, $message) {
    $result = [];
    for ($i = 0; $i < strlen($message); $i++) {
        $result[] = ord($message[$i]) ^ $key->getKeyByte();
    }
    return $result;
}

$key = new KeyStream(10);

$message = "Hello, World";

$cipher = encrypt($key, $message);
echo "</br>";
echo "Encrypted: ";
foreach ($cipher as $byte) {
    echo chr($byte);
}
echo "\n";

$key = new KeyStream(10);

$decryptedMessage = encrypt($key, implode(array_map("chr", $cipher)));

echo "</br>";
echo "Decrypted: ";
foreach ($decryptedMessage as $byte) {
    echo chr($byte);
}
echo "\n";

?>
