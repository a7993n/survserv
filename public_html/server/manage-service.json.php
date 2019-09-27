<?php

header('Cache-control: private');
header('Content-type: application/json');

require_once './classes/Server.class.php';

$callback = $_GET['callback'];
$process = $_GET['process'];
$action = $_GET['action'];
$process_clean = (string) escapeshellarg($process);
$action_clean = (string) escapeshellarg($action);

$success = Server::manageService($process_clean, $action_clean);

$json = json_encode(array(
	'success'	=>	$success
));
print $callback.'('. $json . ')';

?>