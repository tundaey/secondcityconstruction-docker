<?php 
// config/autoload/database.local.php

$host	= 'secondcityconstructioncom_mysql_1';
$port   = '3306';
$dbname = 'secondcityconstructioncom';
$user 	= 'secondcity';
$pass	= 'KxLnMY8ySfHZ9V3C';

$dbParams = array(
		'database' => $dbname,
        'port'     => $port,
		'username' => $user,
		'password' => $pass, 
		'hostname' => $host,
);

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'db' => array(
        'driver' => 'pdo',
        'dsn' => "mysql:dbname={$dbParams['database']};host={$dbParams['hostname']};port={$dbParams['port']}",
        'username' => $dbParams['username'],
        'password' => $dbParams['password'],
        /*'driver_options' => array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"),*/
    ),
);