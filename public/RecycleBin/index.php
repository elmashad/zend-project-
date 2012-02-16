<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
			
			

			
			
//Test			
require_once 'Zend/Registry.php';





//require_once 'Zend/Controller/Front.php';
//Zend_Controller_Front::run('../application/controllers');










/*-
// Note This line is to put all configs in ARRAYS

	require_once 'Zend/Controller/Front.php';
	require_once 'Zend/Registry.php';
	require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
	 
	Zend_Registry::set('title',"My First Application");
	 
	$arrName = array('Ilmia Fatin','Aqila Farzana', 'Imanda Fahrizal');
	Zend_Registry::set('credits',$arrName);
	 
	$params = array('host'      =>'localhost',
	                    'username'  =>'root',
	                    'password'  =>'admin',
	                    'dbname'    =>'zend'
	                   );
	$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
	     
	$DB->setFetchMode(Zend_Db::FETCH_OBJ);
	Zend_Registry::set('DB',$DB);



	Zend_Controller_Front::run('../application/controllers');
	 
	?>
-*/





/*-
// Also this
	require_once 'Zend/Controller/Front.php';
	require_once 'Zend/Registry.php';
	require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
	require_once 'Zend/Config.php'; // I create it
	 
	 
	$arrConfig = array(
	      'webhost'=>'localhost',
	      'appName'=>'My First Zend',
	      'database'=>array(
	          'dbhost'=>'localhost',
	          'dbname'=>'zend',
	          'dbuser'=>'root',
	          'dbpass'=>'admin'
	          )
	      );
	 
	$config = new Zend_Config($arrConfig);
	 
	$title  = $config->appName;
	$params = array('host'      =>$config->database->dbhost,
	                'username'  =>$config->database->dbuser,
	                'password'  =>$config->database->dbpass,
	                'dbname'    =>$config->database->dbname
	                );
	 
	 
	Zend_Registry::set('title',$title);
	 
	$arrName = array('Ilmia Fatin','Aqila Farzana', 'Imanda Fahrizal');
	Zend_Registry::set('credits',$arrName);
	 
	$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
	     
	$DB->setFetchMode(Zend_Db::FETCH_OBJ);
	Zend_Registry::set('DB',$DB);
	 
	 
	 
	Zend_Controller_Front::run('../application/controllers');
	 
	?>
-*/

