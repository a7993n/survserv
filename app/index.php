<!DOCTYPE html>
<html lang="en">
<head>
	<title>Surveillance serveur</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="./vendor/bootstrap-2.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="./vendor/jquery/css/smoothness/jquery-ui-1.10.2.custom.min.css">
	<link rel="stylesheet" href="./vendor/chromatable/chromatable.css">
	<link rel="stylesheet" href="./assets/css/styles.css">
	<link rel="stylesheet" href="./assets/css/styles-responsive.css">
	<link rel="shortcut icon" href="./logo.png">
</head>
<body style="margin-top:7%;background: #E6E6E6 !important;"> 
	<div style="background:white !important;color:black !important;" class="navbar navbar-default navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" style="padding-bottom:15px;padding-top:15px;"><img width="200px" alt="Movenpick Marrakech" src="./assets/images/logo.png"></a>
			</div><!--/.container -->
		</div><!--/.navbar-inner -->
	</div><!--/.navbar -->
	<div id="content-container" class="container">
		<div id="overlay" style="display:none;">
			<div style="display:table;width:100%;height:100%;">
				<div style="display:table-cell;vertical-align:middle;"><img src="./assets/images/loader.gif"></div>
			</div>
		</div><!--/#overlay -->
		<div class="row">
		<div class="row" style="margin-left: 0px;">
							<div class="span12" style="margin-bottom:5%;" width="100%">
						<div class="content-box">
							<h2>Localisation du serveur</h2>
							<p>
								<?php // include("position.php"); ?>
</p>
						</div><!--/.content-box -->
					</div>
					<br/>
		<div class="row" style="margin-left: 0px;">
					<div class="span12" width="100%">
						<div class="content-box">
							<h2>Vitesse</h2>
							<p>
								<?php include("sp/sp.php"); ?>
</p>
						</div><!--/.content-box -->
					</div><!--/.span4 -->
					</div>
			<div class="span8">
				<div class="row">
					<div class="span4">
						<div class="content-box">
							<h2>Disponibilité</h2>
							<p><span id="uptime-days" class="loud">0</span> <span class="loud-modifier">Jours</span></p>
							<p>
								<span class="loud-modifier" style="font-size:20px;">
									<span id="uptime-hours" style="color:#333;font-weight:bold;">0</span> Heures <span id="uptime-minutes" style="color:#333;font-weight:bold;">0</span> minutes
								</span>
							</p>
							<p style="font-size:11px;margin:0;"><span id="distro-os"></span> | <span id="distro-version"></span> <span id="distro-arch"></span></p>
						</div><!--/.content-box -->
					</div><!--/.span4 -->
					<div class="span4">
						<div class="content-box">
							<h2> Processeur</h2>
							<p><span id="cpu-used" class="loud">0</span> <span class="loud-modifier">%</span></p>
							<p>
								<span class="loud-modifier" style="font-size:20px;">
									<span id="cpu-idle" style="color:#333;font-weight:bold;">0</span> % Consommable
								</span>
							</p>
						</div><!--/.content-box -->
				   </div><!--/.span4 -->
				</div><!--/.row -->
				<div class="row" >
					<div class="span4">
						<div class="content-box">
							<h2>Mémoire vive</h2>
							<p><span id="memory-used" class="loud">0</span> <span class="loud-modifier">gb</span></p>
							<p>
								<span class="loud-modifier" style="font-size:20px;">
									<span id="memory-free" style="color:#333;font-weight:bold;">0</span> gb libre
								</span>
							</p>
						</div><!--/.content-box -->
					</div><!--/.span4 -->
					<div class="span4">
						<div class="content-box">
							<h2>Disques</h2>
							<table id="drives" class="table-striped table-hover table-condensed">
								<thead>
									<tr>
										<th class="ttip" data-toggle="tooltip" title="File System">FS</th>
										<th>Taille</th>
										<th>Utilisée</th>
										<th>%</th>
										<th>libre</th>
										<th class="ttip" data-toggle="tooltip" title="Mount Point">Point de montage</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div><!--/.content-box -->
					</div><!--/.span4 -->
				</div><!--/.row -->
			</div><!--/.span8 -->
			<div class="span4">
				<div class="content-box two-rows">
					<h2>Les services</h2>
					<table id="services" class="table-striped table-hover table-condensed">
						<thead>
							<tr>
								<th>Nom</th>
								<th>Port</th>
								<th>Etat</th>
								<th>Gérer</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div><!--/.content-box -->
			</div><!--/.span4 -->
		</div><!--/.row -->
		<div class="row" style="margin-left:0px;">
			<div class="span4">
				<div class="content-box two-rows">
					<h2>Logiciel</h2>
					<table id="software" class="table-striped table-hover table-condensed">
						<thead>
							<tr>
								<th>Nom</th>
								<th>La version</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div><!--/.content-box -->
			</div><!--/.span4 -->
			<div class="span4">
				<div class="content-box two-rows">
					<h2>Domains</h2>
					<table id="domains" class="table-striped table-hover table-condensed">
						<thead>
							<tr>
								<th>Nom</th>
								<th>Taille</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
				</div><!--/.content-box -->
			</div><!--/.span4 -->
			<div class="span4">
				<div class="content-box two-rows">
					<h2>Information du processeur</h2>
					<table id="cpus" class="table-striped table-hover table-condensed">
						<thead>
							<tr>
								<th>ID</th>
								<th>Coeurs</th>
								<th>Modèle</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
				</div><!--/.content-box -->
			</div><!--/.span4 -->
		</div><!--/.row -->
	</div><!--/.container -->
	<div id="start-box-container" style="background:#E6E6E6 !important;">
	<center style="margin-top:5%;">
		<img src="./assets/images/logo.png" />
		</center><br/>
		<div style="display:table;width:100%;height:100%;">
		
			<div style="display:table-cell;vertical-align:top;">
				<div id="start-box">
					<h2>Vos Serveurs</h2>
					<select id="start-server" style="margin:10px 0 20px 0;">
						<option value="">Selectionnez un des serveurs</option>
					</select>
				</div>
			</div>
		</div>
	</div><!--/#start-box-container -->
	<div id="generic-error-modal" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Erreur</h3>
		</div>
		<div class="modal-body">
			<p></p>
		</div>
		<div class="modal-footer">
			<a href="javascript:$('#generic-error-modal').modal('hide');" class="btn">Fermer</a>
		</div>
	</div><!--/#start-box-container -->
	
	<script src="./vendor/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="./vendor/jquery/jquery-ui-1.10.2.custom.min.js" type="text/javascript"></script>
	<script src="./vendor/bootstrap-2.3.1/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="./vendor/chromatable/jquery.chromatable.js" type="text/javascript"></script>
	<script src="./vendor/base64.js" type="text/javascript"></script>
	<script src="./vendor/eventsource.js" type="text/javascript"></script>
	<script src="./assets/scripts/server.status.js" type="text/javascript"></script>
	<script src="./assets/scripts/application.js" type="text/javascript"></script>
</body>
</html>
