<?php

require_once __DIR__.'/Src/Autoload.php';

$configFile = 'config.txt';

$fo = new ScreenPresenter\Run($configFile);
$fo->start();