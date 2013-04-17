<?php

require_once __DIR__ . '/../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
	'NoiseLabs' => __DIR__ . PATH_SEPARATOR . '..' . PATH_SEPARATOR . 'vendor',
	'ScreenPresenter' => __DIR__
));

$loader->register();
