<?php

namespace ScreenPresenter;

use NoiseLabs\ToolKit\ConfigParser\ConfigParser;
use ScreenPresenter\Model\Slide;

class Run {

	/** @var \ScreenPresenter\Model\Configuratio */
	protected $configuration;

	public function __construct($configFile) {
		$configParser = new ConfigParser();
		$configParser->read($configFile);

		$this->configuration = new \ScreenPresenter\Model\Configuration($configParser);
	}

	public function start() {
		$configuration = $this->configuration;

		$placeholders = array(
			'###PAGE_TITLE###' => htmlspecialchars($configuration->getTitle()),
			'###HEADER###' => $configuration->getHeader(),
			'###FILES###' => $this->renderFiles(),
			'###CONFIGURATION###' => $this->renderConfiguration()
		);

		$template = file_get_contents(__DIR__ . '/Resources/template.html');
		$template = str_replace(array_keys($placeholders), array_values($placeholders), $template);

		echo $template;
	}

	protected function renderFiles() {
		$content = '';

		foreach ($this->configuration->getFiles() as $file) {
			$info = @getimagesize($file);
			if (!is_array($info)) {
				throw new Exception('Image not found');
			}
			$content .= '<img src="' . htmlspecialchars($file) . '" ' . $info[3] . ' />' . chr(10);
		}
		return $content;
	}

	protected function renderConfiguration() {
		$content = '';

		$slides = $this->configuration->getSlides();

		$singleSlides = array();

		foreach($slides as $slide) {
			/** @var $slide Slide */
			$slide = $slide;
			$slideConfiguration = array();
			$slideConfiguration[] = '"screenNumber":' . $slide->getScreen();
			$slideConfiguration[] = '"name": "' . $slide->getName() . '"';
			$slideConfiguration[] = '"posX":' . $slide->getPosX();
			$slideConfiguration[] = '"posY":' . $slide->getPosY();
			$slideConfiguration[] = '"tooltipWidth":' . $slide->getTooltipWidth();
			$slideConfiguration[] = '"text": "' . $slide->getText() . '"';
			$slideConfiguration[] = '"position": "' . $slide->getPosition() . '"';
			$slideConfiguration[] = '"bgcolor": "' . $slide->getBackgroundColor() . '"';
			$slideConfiguration[] = '"showAsIntro": ' . $this->renderBooleanValue($slide->getShowAsIntro());

			$singleSlides[] = '{' . chr(10) . implode(',' . chr(10), $slideConfiguration) . '}';
		}

		$content = 'config = [' . implode(',', $singleSlides) . ']';

		return '<script type="text/javascript">' . $content . '</script>';
	}

	protected function renderBooleanValue($value) {
		return $value ? 'true' : 'false';
	}

}
