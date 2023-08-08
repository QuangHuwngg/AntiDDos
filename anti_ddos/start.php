<?php

function safe_print($value)
{
	$value .= "";
	return strlen($value) > 1 && (strpos($value, "0") !== false) ? ltrim($value, "0") : (strlen($value) == 0 ? "0" : $value);
}
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['standby'])) {

	// Có tất cả cấu hình của bạn
	$_SESSION['standby'] = $_SESSION['standby'] + 1;

	$ad_ddos_query = 5; // số lượng yêu cầu mỗi giây để phát hiện các cuộc tấn công DDOS
	$ad_check_file = 'check.txt'; // tập tin để ghi trạng thái hiện tại trong quá trình giám sát
	$ad_all_file = 'all_ip.txt'; // tập tin tạm thời
	$ad_black_file = 'black_ip.txt'; // sẽ được nhập vào ip máy zombie
	$ad_white_file = 'white_ip.txt'; // khách truy cập đã đăng nhập ip
	$ad_temp_file = 'ad_temp_file.txt'; // khách truy cập đã đăng nhập ip
	$ad_dir = 'anti_ddos/files'; // thư mục với các tập lệnh
	$ad_num_query = 0; // số lượng yêu cầu hiện tại mỗi giây từ một tệp $check_file
	$ad_sec_query = 0; // ​​sgiây từ một tập tin $check file
	$ad_end_defense = 0; // kết thúc trong khi bảo vệ tệp $check_file
	$ad_sec = date("s"); // giây hiện tại
	$ad_date = date("is"); // thời điểm hiện tại
	$ad_defense_time = 100; // thời gian phát hiện tấn công ddos tính bằng giây tại đó ngừng theo dõi


	$config_status = "";
	function Create_File($the_path, $ad)
	{
		if (!file_exists($ad)) mkdir($ad, 0755, true);
		$handle = fopen($the_path, 'a+') or die('Cannot create file:  ' . $the_path);
		return "Creating " . $the_path . " .... done";
	}


	// Kiểm tra xem tất cả các tệp có tồn tại trước khi khởi chạy kiểm tra không
	$config_status .= (!file_exists("{$ad_dir}/{$ad_check_file}")) ? Create_File("{$ad_dir}/{$ad_check_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_check_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_temp_file}")) ? Create_File("{$ad_dir}/{$ad_temp_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_temp_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_black_file}")) ? Create_File("{$ad_dir}/{$ad_black_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_black_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_white_file}")) ? Create_File("{$ad_dir}/{$ad_white_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_white_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_all_file}")) ? Create_File("{$ad_dir}/{$ad_all_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_all_file}<br>";

	if (!file_exists("{$ad_dir}/../anti_ddos.php")) {
		$config_status .= "anti_ddos.php doesn't exist!";
	}

	if (
		!file_exists("{$ad_dir}/{$ad_check_file}") or
		!file_exists("{$ad_dir}/{$ad_temp_file}") or
		!file_exists("{$ad_dir}/{$ad_black_file}") or
		!file_exists("{$ad_dir}/{$ad_white_file}") or
		!file_exists("{$ad_dir}/{$ad_all_file}") or
		!file_exists("{$ad_dir}/../anti_ddos.php")
	) {

		$config_status .= "Some files doesn't exist!";
		die($config_status);
	}

	// TO verify the session start or not
	require("{$ad_dir}/{$ad_check_file}");

	if ($ad_end_defense and $ad_end_defense > $ad_date) {
		require("{$ad_dir}/../anti_ddos.php");
	} else {
		$ad_num_query = ($ad_sec == $ad_sec_query) ? $ad_num_query++ : '1 ';
		$ad_file = fopen("{$ad_dir}/{$ad_check_file}", "w");

		$ad_string = ($ad_num_query >= $ad_ddos_query) ? '<?php $ad_end_defense=' . safe_print($ad_date + $ad_defense_time) . '; ?>' : '<?php $ad_num_query=' . safe_print($ad_num_query) . '; $ad_sec_query=' . safe_print($ad_sec) . '; ?>';

		fputs($ad_file, $ad_string);
		fclose($ad_file);
	}
} else {

	$_SESSION['standby'] = 1;

	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Refresh: 5, " . $actual_link);
?>
	<link rel="icon" href="https://i.imgur.com/cjdGK7t.png" type="image/x-icon"/>
	<title>Anti DDos System</title>
	<style type="text/css">
		body {
			background-color: #222;
			text-align: center;
		}
		#preloader {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
		#loader {
			display: block;
			position: relative;
			left: 50%;
			top: 50%;
			width: 150px;
			height: 150px;
			margin: -75px 0 0 -75px;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #9370DB;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
		}
		#loader:before {
			content: "";
			position: absolute;
			top: 5px;
			left: 5px;
			right: 5px;
			bottom: 5px;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #BA55D3;
			-webkit-animation: spin 3s linear infinite;
			animation: spin 3s linear infinite;
		}
		#loader:after {
			content: "";
			position: absolute;
			top: 15px;
			left: 15px;
			right: 15px;
			bottom: 15px;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #FF00FF;
			-webkit-animation: spin 1.5s linear infinite;
			animation: spin 1.5s linear infinite;
		}
		@-webkit-keyframes spin {
			0%   {
				-webkit-transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				transform: rotate(0deg);
			}
			100% {
				-webkit-transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				transform: rotate(360deg);
			}
		}
		@keyframes spin {
			0%   {
				-webkit-transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				transform: rotate(0deg);
			}
			100% {
				-webkit-transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				transform: rotate(360deg);
			}
		}
	</style>
	<div id="preloader">
  		<div id="loader"></div>
	</div>

<?php exit();
}
?>