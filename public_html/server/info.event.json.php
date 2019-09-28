<?php

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	header('Access-Control-Allow-Origin: http://movenpick.com');
	header('Access-Control-Allow-Methods: GET');
	header('Access-Control-Allow-Headers: Last-Event-ID, Cache-Control, Authorization, Accept');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');
	exit;
}

header('Cache-Control: no-cache');
header('Content-Type: text/event-stream');
header('Access-Control-Allow-Origin: http://movenpick.com');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Credentials: true');

require_once './classes/Server.class.php';

// compression avec gzip
if (function_exists('apache_setenv')) {
	@apache_setenv('no-gzip', 1);
}
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);
for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
ob_implicit_flush(1);

//  limite
set_time_limit(0);
// end

// streaming des infos en temps reel
while(1) {
	$uptime = Server::getUpTime();
	$cpu = Server::getCPUInfo();
	$memory = Server::getMemoryInfo();
	$drive = Server::getDrivesInfo();
	$services = Server::getServicesInfo(array(
	
		array('name'	=>	'DNS', 		'service'		=>	'domain', 	'process'	=>	'named'),
		array('name'	=>	'HTTP', 	'service'		=>	'http', 	'process'	=>	'httpd'),
		array('name'	=>	'HTTPS', 	'service'		=>	'https', 	'process'	=>	'httpd'),
		array('name'	=>	'NGINX', 	'service'		=>	'',		 	'process'	=>	'nginx'),
		array('name'	=>	'MYSQL', 	'service'		=>	'mysql', 	'process'	=>	'mysqld'),
		array('name'	=>	'IMAP', 	'service'		=>	'imap', 	'process'	=>	'postfix'),
		array('name'	=>	'IMAP-SSL', 'service'		=>	'imaps', 	'process'	=>	'postfix'),
		array('name'	=>	'SMTP', 	'service'		=>	'smtp', 	'process'	=>	'postfix'),
		array('name'	=>	'SMTP-SSL', 'service'		=>	'smtps', 	'process'	=>	'postfix'),
		array('name'	=>	'FTP', 		'service'		=>	'ftp', 		'process'	=>	'vsftpd'),
		array('name'	=>	'SFTP',		'service'		=>	'sftp',		'process'	=>	'vsftpd'),
		array('name'	=>	'SSH', 		'service'		=>	'ssh', 		'process'	=>	'sshd')
	));
	$software = Server::getSoftwareInfo();
	$domains = Server::getDomainList('/var/www/', array(
		'awstats',
		'chroot',
		'default',
		'fs',
		'fs-passwd',
		'httpsdocs',
		'.skel'
	));
	
	$json = json_encode(array(
		'uptime'	=>	$uptime,
		'cpu'		=>	$cpu,
		'memory'	=>	$memory,
		'drive'		=>	$drive,
		'services'	=>	$services,
		'software'	=>	$software,
		'domains'	=>	$domains
	));
	echo "data: " . $json . "\n\n";
	flush();
	sleep(2);
}

?>