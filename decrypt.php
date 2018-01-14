<!DOCTYPE html>
<html>
	<head>
		<title>One-time Password Retrieval - Decrypt</title>
	</head>
	<body>
<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];
	$password_filename = 'passwords/'.$id;
	if(file_exists($password_filename)) {
		$password_file = fopen($password_filename, 'rw');
		list($encrypted_string, $iv, $tag) = explode('::', hex2bin(fread($password_file, filesize($password_filename))), 3);		
		$private_key = hex2bin($_POST['privatekey']);
		$cipher = 'aes-256-gcm';
		
		$decrypted_string = openssl_decrypt($encrypted_string, $cipher, $private_key, $options=OPENSSL_RAW_DATA, $iv, $tag);
		if($decrypted_string) {
			fclose($password_file);
			unlink($password_filename);
		}
?>
		<div id="decryptionresults">
			<table>
				<tr>
					<td>Decrypted String: </td><td id="decryptedstring"><?=$decrypted_string ?></td>
				</tr>
			</table>
		</div>
<?php
	}
	else {
?>
		No such password!!
<?php
	}
}
else {
?>
		<form action="decrypt.php" method="post">
			<table>
				<tr>
					<td><label for="stringtodecrypt">Id: </label></td><td><input id="id" name="id" type="text"/></td>
				</tr>
				<tr>
					<td><label for="privatekey">Private Key: </label></td><td><input id="privatekey" name="privatekey" type="text"/></td>
				</tr>
			</table>
			<button type="submit" onclick="location.href='encrypt.php'">Decrypt</button>
		</form>
<?php
}
?>
	</body>
</html>