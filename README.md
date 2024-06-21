# Modern-cryptography-in-php
Modern cryptography in php
Welcome to “Modern Cryptography in PHP” – a comprehensive repository dedicated to implementing cutting-edge cryptographic techniques in PHP. This repository serves as a resource for PHP developers looking to enhance the security of their applications through modern encryption standards.

Inside, you’ll find examples, best practices, and libraries that adhere to the latest advancements in cryptography. Whether you’re securing web applications, safeguarding user data, or ensuring secure communication channels, this repository aims to equip you with the tools and knowledge necessary for robust security in the digital age.

Explore, contribute, and stay secure!

**blockCipherDES.php :** DES-CBC block cipher example

**caesar_cipher.php :**  Caesar cipher implimentation in php

**php-decrypt-caesar.php :** Php caesar cipher decryption

**simple_permutations.php :** Permutations demo in php

**streamCipher.php :** Stream cipher demo in php


To create public key and private key paid use openssl on ubnutu:

Commands:

# Generate a 2048-bit RSA private key
**openssl genpkey -algorithm RSA -out private_key.pem -pkeyopt rsa_keygen_bits:2048**

# Extract the public key from the private key
**openssl rsa -pubout -in private_key.pem -out public_key.pem**
