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

namespace ScreenPresenter\Model;

use NoiseLabs\ToolKit\ConfigParser\ConfigParser;

class Configuration {

	/** @var string */
	protected $title = '';

	protected $header = '';

	protected $backgroundColor = '';

	/** @var array */
	protected $files = array();

	/** @var array */
	protected $slides = array();


	function __construct(ConfigParser $config) {
		foreach ($config as $section => $sectionConfig) {
			if ($section === 'default') {
				if (!isset($sectionConfig['title'])) {
					throw new \Exception('Title not defined');
				}
				$this->setTitle($sectionConfig['title']);
				$this->backgroundColor = $sectionConfig['backgroundColor'];
				$this->setFiles($sectionConfig['files']);

				if (isset($sectionConfig['header'])) {
					$this->header = $sectionConfig['header'];
				}
			} else {
				$this->addSlide(new Slide($section, $sectionConfig));
			}
		}
	}

	/**
	 * @param array $slides
	 */
	public function setSlides($slides) {
		$this->slides = $slides;
	}

	/**
	 * @return array
	 */
	public function getSlides() {
		return $this->slides;
	}

	public function addSlide($slide) {
		$this->slides[] = $slide;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	public function setFiles($files) {
		$fileArray = explode(',', $files);
		foreach ($fileArray as $file) {
			$file = trim($file);
			if (is_file($file)) {
				$this->files[] = $file;
			}
		}
	}

	/**
	 * @return string
	 */

	public function getTitle() {
		return $this->title;
	}

	public function getHeader() {
		return $this->header;
	}

	/**
	 * @return array
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * Get background color
	 *
	 * @return string
	 */
	public function getBackgroundColor() {
		return $this->backgroundColor;
	}

}