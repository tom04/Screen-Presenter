<?php

namespace ScreenPresenter\Model;

use NoiseLabs\ToolKit\ConfigParser\ConfigParser;

class Configuration {

	/** @var string */
	protected $title = '';

	protected $header = '';

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



}