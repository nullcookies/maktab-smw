<?php

namespace controllers\front;

use \system\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class BackupController extends Controller {
    
    public function db() {
		include_once(BASEPATH . '/library/mysqldump-php-master/src/Ifsnop/Mysqldump/Mysqldump.php');
		$dumpSettings = array(
			'compress' => \Ifsnop\Mysqldump\Mysqldump::GZIP,
			'no-data' => false,
			'add-drop-table' => true,
			'single-transaction' => true,
			'lock-tables' => true,
			'add-locks' => true,
			'extended-insert' => true,
			'disable-foreign-keys-check' => true,
			'skip-triggers' => false,
			'add-drop-trigger' => true,
			'databases' => $this->config['db']['dbname'],
			'add-drop-database' => true,
			'hex-blob' => true
		);
	
		$dump = new \Ifsnop\Mysqldump\Mysqldump($this->config['db']['dsn'], $this->config['db']['username'], $this->config['db']['password'], $dumpSettings);
		$dump->start('backups/' . $this->config['db']['dbname'] . '.sql.gz');
		
		exit;
    }

}
