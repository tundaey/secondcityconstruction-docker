<?php 
// request db
$host = $_SERVER['HTTP_HOST'];
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

switch ($matches[0]) {
    case 'projectwellnessnow.com' :
        $data = array(
            'uri'       => 'projectwellnessnow.com',
            'dbname'    => 'projectwellnessnow.com',
            'media'     => '1',
            'blog_excerpt'  => '100 words',
            'site_name' => 'Project Wellness Now',
            'categories' => array('1' => 'Article', '2' => 'News', '22' => 'Recipes', '25' => 'Beyond Conscious Illusion')
            );
    break;
        
    case 'storsky.com' :
        $data = array(
        'uri'       => 'projectwellnessnow.com',
        'dbname'    => 'projectwellnessnow.com',
        'media'     => '1',
        'blog_excerpt'  => '100 words',
        'site_name' => 'storsky'
            );
    break;
    
    case 'zerubariel.com' :
        $data = array(
        'uri'       => 'zerubariel.com',
        'dbname'    => 'zerubariel.com',
        'media'     => '1',
        'blog_excerpt'  => '100 words',
        'site_name' => 'zerubariel'
            );
    break;
            
    case 'gowebvision.com' :
        $data = array(
        'uri'       => 'gowebvision.com',
        'dbname'    => 'com.gowebvision',
        'media'     => '3',
        'blog_excerpt'  => '100 words',
        'site_name' => 'WebVision',
        'categories' => array('1' => 'Blog')
            );
    break;
            
    case 'treesanta.com' :
        $data = array(
        'uri'       => 'treesanta.com',
        'dbname'    => 'treesanta.com',
        'media'     => '4',
        'categories' => array('1' => 'Products'),
        'blog_excerpt'  => '100 words',
        'site_name' => 'Tree Santa'
            );
    break;

    case 'secondcityconstruction.com' :
        $data = array(
        'uri'       => 'secondcityconstruction.com',
        'dbname'    => 'secondcityconstruction.com',
        'media'     => '5',
        'blog_excerpt'  => '100 words',
        'site_name' => 'Second City Construction',
        'categories' => array('1' => 'Blog')
            );
    break;

    case 'shmcleaning.com' :
        $data = array(
        'uri'       => 'shmcleaning.com',
        'dbname'    => 'shmcleaning.com',
        'media'     => '6',
        'blog_excerpt'  => '100 words',
        'site_name' => 'SHM Cleaning',
        'categories' => array('1' => 'Blog')
        );
        break;
        
    case 'bigbolt.net' :
        $data = array(
        'uri'           => 'bigbolt.net',
        'dbname'        => 'bigbolt.net',
        'media'         => '7',
        'blog_excerpt'  => '100 words',
        'site_name' => 'Big Bolt',
        );
    break;
}

$data = array(
    'uri'       => 'secondcityconstruction.com',
    'dbname'    => 'secondcityconstructioncom',
    'media'     => '5',
    'blog_excerpt'  => '100 words',
    'site_name' => 'Second City Construction',
    'categories' => array('1' => 'Blog')
);

/*$host	= 'standard.cugsmutvmhvj.us-east-1.rds.amazonaws.com';*/
$host	= 'mysql';
$port   = '3306';
$dbname = $data['dbname'];
$user 	= 'root';
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
       /* 'driver_options' => array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"),*/
    ),
    'website' => $data
);
