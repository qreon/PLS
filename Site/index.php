<!DOCTYPE html>
<?php
	require 'folderListing.php';
	require 'vars.php';
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
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="css/sb-admin.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="css/plugins/morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript">
		//soundManager.url = 'swf/';
		soundManager.debugMode = true;

		var CatchMe;
		soundManager.onload = function()
		{
			CatchMe = soundManager.createSound(
				{
					id : "Catch me",
					url : "coucou.mp3",
					onload : function() {
					  document.getElementById("loading").innerHTML = "Chargement terminé !";
					}
				}
			);

			CatchMe.setPan(-100);
			CatchMe.play();
			CatchMe.setPan(-100);
		}
	</script>

	<script type="text/javascript">
		//AJAX
		function reloadFolderStructure(str)
		{
			var xmlhttp;
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
				{
					document.getElementById("folder-list").innerHTML = xmlhttp.responseText;
				}
			}

			xmlhttp.open("POST","folderListing.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("folder=" + str);
		}
	</script>
	<script type="text/javascript" src="jquery.js"></script>

</head>

<body>

	<div id="wrapper">

		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"> Stream Audio</a>
			</div>
			<!-- Top Menu Items -->
			<ul class="nav navbar-right top-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Se connecter <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li style="padding-left:5px; padding-right:5px;">
							<form role="form">
							<div class="form-group">
							  <label for="exampleInputLogin1">Login</label>
							  <input type="login" class="form-control" id="exampleInputLogin1" placeholder="Login">
							</div>
							<div class="form-group">
							  <label for="exampleInputPassword1">Password</label>
							  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
							</div>
							<button type="submit" class="btn btn-default">Submit</button>
						  </form>
						</li>
					</ul>
				</li>
			</ul>
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<li class="active">
						<a href="javascript:;" data-toggle="collapse" data-target="#musique"><i class="fa fa-music"></i> Ma musique <i class="fa fa-fw fa-caret-down"></i></a>
						<ul id="musique" class="collapse">
							<li class="active">
								<a href="index.html">Répertoires</a>
							</li>
							<li>
								<a href="addMusic.html">Ajouter musique</a>
							</li>
							<li>
								<a href="#">Rechercher musique</a>
									<li>
										<form>
											<input type="text" name="search" style="border-radius:5px; margin-left:17%; max-width:65%;"/>
										</form>
									</li>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript:;" data-toggle="collapse" data-target="#playlist"><i class="fa fa-folder"></i> Playlist <i class="fa fa-fw fa-caret-down"></i></a>
						<ul id="playlist" class="collapse">
							<li>
								<a href="createPlaylist.html">Créer playlist</a>
							</li>
								 <li>
								<a href="#">NomPlaylist1 <i class="fa fa-times"></i></a>

							</li>
							<li>
								<a href="#">NomPlaylist2 <i class="fa fa-times"></i></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>

		<div id="page-wrapper">

			<div class="container-fluid sd" id="center-panel">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Ma musique <small>Répertoire</small>
						</h1>
						<ol class="breadcrumb">
							<li class="active">
								<i class="fa fa-folder-o"></i> Répertoire
							</li>
						</ol>
					</div>
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Dossier musique</h3>
						</div>
						<div class="panel-body">
							<div class="list-group" id="folder-list">
								<?php
									echo(getFolderStructure($musicDir.'Carlos/'));
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
			<!-- /.container-fluid -->

			<div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" style="-moz-box-shadow: 0px 0px 15px 1px #343434;-webkit-box-shadow: 0px 0px 15px 1px #343434;-o-box-shadow: 0px 0px 15px 1px #343434;box-shadow: 0px 0px 15px 1px #343434;filter:progid:DXImageTransform.Microsoft.Shadow(color=#343434, Direction=315, Strength=15);">
				<div class="container">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<ul class="nav navbar-nav navbar-left">
							<li>
								<a class="navbar-brand" href="#">NomDeLaMusique </br> NomAuteur </br> Album</a>
							</li>
						</ul>

					</div>

					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li>
								<div class="col-lg-12" style="padding-top:10px; margin:auto;">
									<button class="btn btn-lg btn-default" onclick="CatchMe.play();"><i class="fa fa-play"></i></button>
									<button class="btn btn-lg btn-default" onclick="CatchMe.pause();"><i class="fa fa-pause"></i></button>
									<button class="btn btn-lg btn-default" onclick="CatchMe.mute();"><i class="fa fa-volume-off"></i></button>
									<button class="btn btn-lg btn-default" onclick="CatchMe.unmute();"><i class="fa fa-volume-up"></i></button>
									<button class="btn btn-primary"><i class="fa fa-share"></i></button>

									<div class="btn-group dropup">
										<button class="btn btn-success"><i class="fa fa-plus"></i></button>
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">NomPlaylist1 <i class="fa fa-square-o"></i></a></li>
											<li><a href="#">NomPlaylist2 <i class="fa fa-square-o"></i></a></li>
										</ul>
									</div>

									<button class="btn btn-warning"><i class="fa fa-star"></i></button>
									<button class="btn btn-danger"><i class="fa fa-download"></i></button>
									<input id="time" type="range" value="0" min="0" max="300">
									<p style="color:white;">00:00/00:00</p>
								</div>
							</li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
			</div>

		</div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

	<!-- jQuery Version 1.11.0 -->
	<script src="js/jquery-1.11.0.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>

	<!-- Morris Charts JavaScript -->
	<script src="js/plugins/morris/raphael.min.js"></script>
	<script src="js/plugins/morris/morris.min.js"></script>
	<script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
