<?php

require_once('lib/ScreenPresenter.php');


$files = array(
	'demoscreen1.jpg', 'demoscreen2.jpg'
);

$instance = new screenpresenter();
$instance->setFilePath('screens/');
$instance->setFiles($files);
$instance->setPageTitle('My screens');
$instance->setConfigFile('js/config_short.js');
$instance->run();