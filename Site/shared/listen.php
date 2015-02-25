<!DOCTYPE html>
<?php
	require '../folderListing.php';
	require '../vars.php';
?>

<html lang="fr">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Stream Audio</title>

	<!-- Bootstrap Core CSS -->
	<link href="../css/bootstrap.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../sb-admin.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="../css/plugins/morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript" src="../js/jquery-1.11.0.js"></script>
	<script type="text/javascript" src="../script/soundmanager2.js"></script>
	<script type="text/javascript" src="shared.js"></script>
</head>

<body>
	<div class="container-fluid sd" id="center-panel">
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Partage</h3>
					</div>
					<div class="panel-body">
						<div class="list-group" id="folder-list">
							<?php
								echo(requestedMusic());
							?>
						</div>

						<!-- ça peut toujours servir...-->
						<!--<div class="text-right">
							<a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
						</div>-->

					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="botnav" class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" style="-moz-box-shadow: 0px 0px 15px 1px #343434;-webkit-box-shadow: 0px 0px 15px 1px #343434;-o-box-shadow: 0px 0px 15px 1px #343434;box-shadow: 0px 0px 15px 1px #343434;filter:progid:DXImageTransform.Microsoft.Shadow(color=#343434, Direction=315, Strength=15);">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#botnavcol">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
			 	</button>
			</div>
			<div class="collapse navbar-collapse" id="botnavcol">
				<ul class="nav navbar-nav" id="botnavcont">
					<li>
						<span class="navbar-brand" id="musicInfo">NomDeLaMusique</span>
						<div style="padding-top:10px; margin:auto;" id="player">
							<div id="buttons">
								<span id="playDiv">
									<button class="btn btn-lg btn-default disabled" onclick="play();" id="playBtn"><i class="fa fa-play"></i></button>
								</span>
								<span id="volDiv">
									<button class="btn btn-lg btn-default disabled" onclick="mute();" id="muteBtn"><i class="fa fa-volume-up"></i></button>
								</span>

								<span id="dlDiv">
									<a class="btn btn-danger disabled" id="dlBtn"><i class="fa fa-download"></i></a>
								</span>
							</div>
							<div id="timeCtl">
								<span id="timeRange"><input id="time" type="range" min="0" max="1000" step="1" value="0" onmousedown="rangePressed()" onmouseup="rangeReleased()"/></span>
								<span style="color:white;" id="timeCpt">00:00 / 00:00</span>
							</div>
						</div>
					</li>
					<li id="shrLink">
					</li>
				</ul>
			</div>
		</div>
	</div>

</body>
</html>