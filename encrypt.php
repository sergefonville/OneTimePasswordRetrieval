<!DOCTYPE html> 
<html>
	<head>
		<title>One-time Password Retrieval - Encrypt</title>
	</head>
	<body>
<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$stringtoencrypt = $_POST['stringtoencrypt'];
	$private_key = openssl_random_pseudo_bytes(64);
	$cipher = 'aes-256-gcm';
	$ivlen = openssl_cipher_iv_length($cipher);
	$iv = openssl_random_pseudo_bytes($ivlen);
	$encrypted_string = openssl_encrypt($stringtoencrypt, $cipher, $private_key, $options=OPENSSL_RAW_DATA, $iv, $tag);
	$id = bin2hex(openssl_random_pseudo_bytes(64));
	$password_file = fopen('passwords/'.$id, 'w');
	fwrite($password_file, bin2hex($encrypted_string.'::'.$iv.'::'.$tag));
	fclose($password_file);
	?>
		<div id="encryptionresults">
			<table>
				<tr>
					<td>Id: </td><td id="id"><?=$id ?></td>
				</tr>
				<tr>
					<td>Private Key: </td><td id="privatekey"><?=bin2hex($private_key) ?></td>
				</tr>
			</table>
		</div>
<?php
}
else {
?>
		<form action="encrypt.php" method="post">
			<label for="stringtoencrypt">String to Encrypt: </label><input id="stringtoencrypt" name="stringtoencrypt" type="text"/>
			<button type="submit" onclick="location.href='encrypt.php'">Encrypt</button>
		</form>
<?php
}
?>
	</body>
</html>