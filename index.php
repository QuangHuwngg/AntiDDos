<?php
	try{
		if (!file_exists('anti_ddos/start.php'))
			throw new Exception ('anti_ddos/start.php does not exist');
		else
			require_once('anti_ddos/start.php'); 
	} 
	// Hình ảnh xác thực ngoại lệ nếu xảy ra sự cố
	catch (Exception $ex) {
		echo '<div style="padding:10px;color:white;position:fixed;top:0;left:0;width:100%;background:black;text-align:center;">'.
			'The Anti DDos System failed to load '.
			'properly on this Web Site, please de-comment the \'catch Exception\' to see what happening!</div>';
		//Print out the exception message.
		//echo $ex->getMessage();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/flottant.css">
		<title>Anti DDos System</title>
		<link rel="icon" href="https://i.imgur.com/cjdGK7t.png" type="image/x-icon"/>
	</head>
	<body>
		<center>
			<div class="container">
					<img src="https://i.imgur.com/8GfKO2l.gif" style="border-radius: 100%;width:200px;"><br>
				<h1>Anti DDos System</h1>
				<p>Trang web này được bảo vệ bởi Anti DDos System</p>
			</div>
		</center>
	</body>
</html>
