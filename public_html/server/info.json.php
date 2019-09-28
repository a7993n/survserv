<?php

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	header('Access-Control-Allow-Origin: http://movenpick.com');
	header('Access-Control-Allow-Methods: GET');
	header('Access-Control-Allow-Headers: Content-Type, Authorization, Accept');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');
	exit;
}

header('Cache-Control: no-cache');
header('Content-type: application/json');
header('Access-Control-Allow-Origin: http://movenpick.com');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Credentials: true');

require_once './classes/Server.class.php';

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
$software = Server::GetSoftwareInfo();
$domains = Server::getDomainList('/var/www/', array(
	'.skel',
	'awstats',
	'chroot',
	'default',
	'fs',
	'fs-passwd',
	'httpsdocs'
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
print $json;

?>