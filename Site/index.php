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
	<link href="sb-admin.css" rel="stylesheet">

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

	<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
	<script type="text/javascript" src="script/soundmanager2.js"></script>
	<script type="text/javascript" src="controls.js"></script>
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
									echo(getFolderStructure($musicDir, true));
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

			<div id="botnav" class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" style="-moz-box-shadow: 0px 0px 15px 1px #343434;-webkit-box-shadow: 0px 0px 15px 1px #343434;-o-box-shadow: 0px 0px 15px 1px #343434;box-shadow: 0px 0px 15px 1px #343434;filter:progid:DXImageTransform.Microsoft.Shadow(color=#343434, Direction=315, Strength=15);">
				<div class="container">
					<!--
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<ul class="nav navbar-nav navbar-left">
							<li>
								<a class="navbar-brand" id="musicInfo" href="#">NomDeLaMusique </br> NomAuteur </br> Album</a>
							</li>
						</ul>

					</div>
					-->
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
										<span id="shrDiv">
											<div class="btn-group dropup" role="group" id="shrGroup">
												<button type="button" class="btn btn-default btn-primary dropdown-toggle" id="shrToggle" data-toggle="dropdown" aria-expanded="false">
													<i class="fa fa-share"></i>&nbsp;&nbsp;
													<span class="caret"></span>
												</button>
												<ul class="dropdown-menu" id="shrDropup" role="menu">
													<li class="disabled" id="shrMusic"><a href="#">Partager la musique</a></li>
													<?php
														echo("<li id=\"shrFolder\" onclick=\"share('". $musicDir . "');\"><a href=\"#\">Partager le dossier</a></li>");
													?>
												</ul>
											</div>
										</span>

										<div class="btn-group dropup" id="plBtn">
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

										<button class="btn btn-warning" id="favBtn"><i class="fa fa-star"></i></button>
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
					<!--/.nav-collapse
					<nav class="navbar navbar-default" role="navigation">
					   <div class="navbar-header">
						  <button type="button" class="navbar-toggle" data-toggle="collapse" 
							 data-target="#example-navbar-collapse">
							 <span class="sr-only">Toggle navigation</span>
							 <span class="icon-bar"></span>
							 <span class="icon-bar"></span>
							 <span class="icon-bar"></span>
						  </button>
						  <a class="navbar-brand" href="#">TutorialsPoint</a>
					   </div>
					   <div class="collapse navbar-collapse" id="example-navbar-collapse">
						  <ul class="nav navbar-nav">
							 <li class="active"><a href="#">iOS</a></li>
							 <li><a href="#">SVN</a></li>
							 <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								   Java <b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
								   <li><a href="#">jmeter</a></li>
								   <li><a href="#">EJB</a></li>
								   <li><a href="#">Jasper Report</a></li>
								   <li class="divider"></li>
								   <li><a href="#">Separated link</a></li>
								   <li class="divider"></li>
								   <li><a href="#">One more separated link</a></li>
								</ul>
							 </li>
						  </ul>
					   </div>
					</nav>
					-->

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
