<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form name="abc" method="POST">
		<table>
			<tr>
				<td>password</td>
				<td><input type="text" name="pass" id="pass" value=""></td>
			</tr>
			<tr><td></td><td><input type="submit" name="submit" value="submit" onclick="return encrypt();"></td></tr>
		</table>
	</form>

<script src="sb_admin/js/aes.js"></script>
<script>
	function encrypt(){
		var pass = document.getElementById("pass").value;
		var hash = CryptoJS.MD5(pass);
		document.write(hash);
		return true;
	}
</script>
</body>
</html>