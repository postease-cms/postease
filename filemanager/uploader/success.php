<?php
$config = include '../config/config.php';
if (empty($config['java_upload']) || empty($config['upload_files'])) { http_response_code(403); exit('Uploader disabled'); }
?>
<html>
<head>
	<!--JUPLOAD_JSCRIPT-->
	<title>JUpload RESPONSIVE filemanager</title>
	<style>
		body {
			padding: 0px;
			margin: 0px;
		}
	</style>
	<meta http-equiv="refresh"
		  content="3;url=index.php?path=<?php echo strip_tags(preg_replace("/[^a-zA-Z0-9\.\[\]_| -]/", '', $_GET['path'])); ?>">
</head>
<body>
<center><br/><br/>
	<img src="success.jpg" alt="success">
</center>
</body>
</html>