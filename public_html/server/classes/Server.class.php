<?php

 
class Server {
	
	/**
	 * Constructeur
	 *
	 * @return void
	 * @throws Exception
	**/
	public function __construct() {
		throw new Exception('Erreur de la creation de l instance');
	}
	
	/**
	 * Methode streaming du serveur
	 *
	 * @return Array
	**/
	public function getUpTime() {
		$uptime_raw = exec('uptime');
		preg_match_all('/\d{1,3}\sday/', $uptime_raw, $uptime_days);
		preg_match_all('/\d{1,2}:\d{1,2}\,/', $uptime_raw, $uptime_hours);
		$days = str_replace(' day', '', $uptime_days[0][0]);
		$hours = str_replace(',', '', $uptime_hours[0][0]);
		return array(
			'days'	=>	empty($days) ? '0' : $days,
			'hours'	=>	empty($hours) ? '00:00' : $hours
		);
	}
	
	/**
	 * Methode info CPU
	 *
	 * @return Array
	**/
	public function getCPUInfo() {
		exec('cat /proc/cpuinfo', $cpus_raw);
		$cpus = array();
		$iteration = 0;
		for($i = 0; $i < count($cpus_raw); $i++){
			if(empty($cpus_raw[$i])) {
				$iteration++;
				continue;
			}
			$parts = explode(':', $cpus_raw[$i]);
			$cpus[$iteration][str_replace(' ', '_', trim($parts[0]))] = trim($parts[1]);
		}
		for($i = 0; $i < count($cpus); $i++){
			ksort($cpus[$i]);	
		}
		exec('cat /proc/loadavg', $load_raw);
		$load_parts = explode(' ', $load_raw[0]);
		$load = $load_parts[0] * 100 / count($cpus);
		return array(
			'used'	=>	number_format($load, 2),
			'idle'	=>	number_format(100 - $load, 2),
			'cpus'	=>	$cpus
		);
	}
	
	/**
	 * Methode infos RAM
	 *
	 * @return Array
	**/
	public function getMemoryInfo() {
		exec('cat /proc/meminfo', $memory_raw);
		$memory_free = 0;
		$memory_total = 0;
		$memory_used = 0;
		for($i = 0; $i < count($memory_raw); $i++){
			if(strstr($memory_raw[$i], 'MemTotal')){
				$memory_total = filter_var($memory_raw[$i], FILTER_SANITIZE_NUMBER_INT);
				$memory_total = $memory_total / 1048576;
			}
			if(strstr($memory_raw[$i], 'MemFree')){
				$memory_free = filter_var($memory_raw[$i], FILTER_SANITIZE_NUMBER_INT);
				$memory_free = $memory_free / 1048576;
			}
		}
		$memory_used = $memory_total - $memory_free;
		return array(
			'used'	=>	number_format($memory_used, 2),
			'free'	=>	number_format($memory_free, 2),
			'total'	=>	number_format($memory_total, 2)
		);	
	}
	
	/**
	 * Methode HDD
	 *
	 * @return Array
	**/
	public function getDrivesInfo() {
		exec('df -h', $drives_raw);
		$drives = array();
		for($i = 0; $i < count($drives_raw); $i++){
			$drive_parts = preg_split('/ +/', $drives_raw[$i]);
			if(count($drive_parts) != 6) continue;
			$drives[] = array(
				'file_system'	=>	$drive_parts[0],
				'size'			=>	$drive_parts[1],
				'used'			=>	$drive_parts[2],
				'free'			=>	$drive_parts[3],
				'used_percent'	=>	$drive_parts[4],
				'mounted'		=>	$drive_parts[5]
			);
		}
		return $drives;
	}
	
	/**
	 * Methode infos des services
	 *
	 * @return Array
	**/
	public function getServicesInfo($services_scan) {
		$services = array();
		foreach ($services_scan as $service) {
			$running = false;
			$port = getservbyname($service['service'], 'tcp');
			$pid = array();
			$pids = array();
			if(isset($service['process'])) {
				exec('ps cax -eo user,pid,etime,%cpu,command | grep ' . (isset($service['command']) ? $service['command'] : $service['process']), $pid);
				for($i = 0; $i < count($pid); $i++){
					$pid_parts = preg_split('/ +/', $pid[$i]);
					$started = $pid_parts[2];
					$started_days_parts = explode('-', $started);
					$started_days = count($started_days_parts) == 1 ? 0 : $started_days_parts[0];
					if(count($started_days_parts) == 1){
						$started_days_hours_minutes_seconds = explode(':', $started_days_parts[0]);
					} else {
						$started_days_hours_minutes_seconds = explode(':', $started_days_parts[1]);
					}
					if(count($started_days_hours_minutes_seconds) == 2) array_unshift($started_days_hours_minutes_seconds, '0');
					array_unshift($started_days_hours_minutes_seconds, $started_days);
					$pids[] = array(
						'user'	=>	$pid_parts[0],
						'pid'	=>	$pid_parts[1],
						'started'	=>	array(
							'days'		=>	$started_days_hours_minutes_seconds[0],
							'hours'		=>	$started_days_hours_minutes_seconds[1],
							'minutes'	=>	$started_days_hours_minutes_seconds[2],
							'seconds'	=>	$started_days_hours_minutes_seconds[3]
						),
						'cpu'	=>	$pid_parts[3]
					);	
				}
				if(!empty($pid)){
					$running = true;
				}
			}
			$services[] = array(
				'name'	=>	$service['name'],
				'port'	=>	$port,
				'process'	=>	$service['process'],
				'pids'		=>	$pids,
				'running'	=>	$running
			);
		}	
		return $services;
	}
	
	/**
	 * Methode pour la gestion des services
	 *
	 * @return boolean
	**/
	public function manageService($process, $action) {
		exec('./service ' . $process . ' ' . $action, $output, $status);
		$status = 0;
		if($status != 0){
			return false;
		} else {
			return true;	
		}
	}
	
	/**
	 * Methode pour infos du logiciel & kernel du serveur
	 *
	 * @return Array
	**/
	public function getSoftwareInfo() {
		$softwares = array();
		$software = array();
		$iteration = 0;
		$software_key = '';
		$distro = array();
		exec('rpm -qai | grep "Name        :\|Version     :\|Release     :\|Install Date:\|Group       :\|Size        :"', $software_raw);
		for($i = 0; $i < count($software_raw); $i++){
			preg_match_all('/(?P<name1>.+): (?P<val1>.+) (?P<name2>.+): (?P<val2>.+)/', $software_raw[$i], $matches);
			if(empty($matches['name1'])) continue;
			if(trim($matches['name1'][0]) == 'Name') $software_key = strtolower(trim(str_replace(array('-', 'Build', 'Source'), array('_', '', ''), $matches['val1'][0])));
			$softwares[$software_key][strtolower(str_replace(' ', '_', trim($matches['name1'][0])))] = trim(str_replace(array('Build', 'Source'), '', $matches['val1'][0]));
			$softwares[$software_key][strtolower(str_replace(' ', '_', trim($matches['name2'][0])))] = trim(str_replace(array('Build', 'Source'), '', $matches['val2'][0]));
		}
		ksort($softwares);
		foreach($softwares as $s){
			$software[] = $s;	
		}
		exec('uname -mrs', $distro_raw);
		exec('cat /etc/*-release', $distro_name_raw);
		$distro_parts = explode(' ', $distro_raw[0]);
		$distro['operating_system'] = $distro_name_raw[0];
		$distro['kernal_version'] = $distro_parts[0] . ' ' . $distro_parts[1];
		$distro['kernal_arch'] = $distro_parts[2];
		return array(
			'packages'	=> $software,
			'distro'	=> $distro
		);
	}
	
	/**
	 * Methode pour savoire les noms domains du vhosts
	 *
	 * @return Array
	**/
	public function getDomainList($directory, $forbidden) {
		exec('ls ' . $directory, $domains_raw);
		$domains = array();
		for($i = 0; $i < count($domains_raw); $i++){
			if(in_array($domains_raw[$i], $forbidden)) continue;
			$domain_size_raw = '';
			exec('du -sh ' . $directory . '/' . $domains_raw[$i], $domain_size_raw);
			$domains[] = array(
				'name'			=>	$domains_raw[$i],
				'size'			=>	str_replace($directory . '/' . $domains_raw[$i], '', $domain_size_raw)
			);
		}
		return $domains;
	}
}

?>
