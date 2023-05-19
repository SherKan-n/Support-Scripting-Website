<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>
	<style type="text/css">
    ::selection{background-color:#e13300;color:#fff}::-moz-selection{background-color:#e13300;color:#fff}body{background-color:#000;margin:40px;font:13px/20px normal Helvetica,Arial,sans-serif;color:#fff;width:auto;height:auto}h1{color:#fff;background-color:transparent;font-size:2vw;font-weight:400;text-align:center;margin:20%;padding:14px 15px 10px 15px;animation:3s test infinite;animation-direction:alternate}@keyframes test{from{text-shadow:1px 1px 2px #add8e6,0 0 25px #00f,0 0 5px #00008b}to{margin:10%;font-size:6vw;text-shadow:1px 1px 2px orange,0 0 25px #ff4500,0 0 5px red}}code{font-family:Consolas,Monaco,Courier New,Courier,monospace;font-size:12px;background-color:#f9f9f9;border:1px solid #d0d0d0;color:#002166;display:block;margin:14px 0 14px 0;padding:12px 10px 12px 10px}#container{margin:10px;border:1px solid #d0d0d0;box-shadow:0 0 8px #d0d0d0;width:auto;height:auto}p{margin:12px 15px 12px 15px}
	</style>
</head>

<body>
	<center>
		<div id="container">
			<h1><?=$heading;?></h1>
			<h3><a href="<?=(isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS'])!=('off')?('https'):('http'))."://".$_SERVER['SERVER_NAME'];?>" style="color:red; text-decoration:none; margin-top:-5px;">Back to Home</a></h3>
		</div>
	</center>
</body>

</html>
