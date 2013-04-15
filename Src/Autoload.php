<?php

require_once __DIR__ . '/../Vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
	'NoiseLabs\\ToolKit\\ConfigParser' => __DIR__ . '\\..\\vendor',
	'ScreenPresenter' => __DIR__
));

$loader->register();
