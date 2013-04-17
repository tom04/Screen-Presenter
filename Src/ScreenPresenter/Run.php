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
			'###BACKGROUNDCOLOR###' => $configuration->getBackgroundColor(),
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

		foreach ($slides as $slide) {
			/** @var $slide Slide */
			$slide = $slide;
			$slideConfiguration = array();
			$slideConfiguration[] = '"screenNumber":' . $slide->getScreen();
			$slideConfiguration[] = '"name": "' . $slide->getName() . '"';
			$slideConfiguration[] = '"posX":' . $slide->getPosX();
			$slideConfiguration[] = '"posY":' . $slide->getPosY();
			$slideConfiguration[] = '"tooltipWidth":' . $slide->getTooltipWidth();
			$text = $slide->getText();
			if (!empty($text)) {
				$slideConfiguration[] = '"text": ' . $this->renderTextValue($slide->getText());
			}
			$slideConfiguration[] = '"position": "' . $slide->getPosition() . '"';
			$slideConfiguration[] = '"bgcolor": "' . $slide->getBackgroundColor() . '"';
			$slideConfiguration[] = '"showAsIntro": ' . $this->renderBooleanValue($slide->getShowAsIntro());

			foreach ($slideConfiguration as $key => $value) {
				$slideConfiguration[$key] = chr(9) . $value;
			}

			$singleSlides[] = chr(10) . '{' . chr(10) . implode(',' . chr(10), $slideConfiguration) . chr(10) . '}';
		}

		$content = 'config = [' . implode(',', $singleSlides) . chr(10) . ']';

		return '<script type="text/javascript">' . chr(10) . $content . chr(10) . '</script>';
	}

	protected function renderBooleanValue($value) {
		return $value ? 'true' : 'false';
	}

	protected function renderTextValue($value) {
		return '\'' . str_replace('\'', '\\\'', $value) . '\'';
	}

}
