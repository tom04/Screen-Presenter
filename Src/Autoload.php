<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Georg Ringer <typo3@ringerge.org>
 * All rights reserved
 *
 * This script is part of the ScreenPresenter project. The ScreenPresenter project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once __DIR__ . '/../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
	'NoiseLabs' => __DIR__ . '//' . '..' . '//' . 'vendor',
	'ScreenPresenter' => __DIR__
));

$loader->register();
