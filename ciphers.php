<?php
$a = sodium_crypto_aead_aes256gcm_is_available();
var_dump($a);
exit();
$ciphers = openssl_get_cipher_methods();
foreach($ciphers as $cipher) {
	echo $cipher.'<br/>';
}
?>