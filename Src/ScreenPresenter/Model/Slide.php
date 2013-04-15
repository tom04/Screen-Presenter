<?php

namespace ScreenPresenter\Model;

class Slide {
	protected $screen;

	protected $name = '';

	protected $posX = 0;
	protected $posY = 0;
	protected $tooltipWidth = 250;
	protected $text = '';
	protected $position = 'B';
	protected $backgroundColor = '';
	protected $showAsIntro = FALSE;


	/**
	 * @param string $name
	 * @param array $config
	 */
	public function __construct($name, array $config) {
		$this->name = str_replace(' ', '-', $name);

		if (!isset($config['screenNumber'])) {
			throw new \Exception('Screen number not defined');
		}
		$this->screen = (int)$config['screenNumber'];

		if (isset($config['posX'])) {
			$this->posX= (int)$config['posX'];
		}
		if (isset($config['posY'])) {
			$this->posY= (int)$config['posY'];
		}
		if (isset($config['tooltipWidth'])) {
			$this->tooltipWidth = $config['tooltipWidth'];
		}
		if (isset($config['text'])) {
			$this->text = $config['text'];
		}
		if (isset($config['position'])) {
			$this->position = $config['position'];
		}
		if (isset($config['backgroundColor'])) {
			$this->backgroundColor = $config['backgroundColor'];
		}
		if (isset($config['showAsIntro'])) {
			$this->showAsIntro = (int)$config['showAsIntro'];
		}
	}

	public function getName() {
		return $this->name;
	}

	public function getPosX() {
		return $this->posX;
	}

	public function getPosY() {
		return $this->posY;
	}

	public function getPosition() {
		return $this->position;
	}

	public function getScreen() {
		return $this->screen;
	}

	public function getText() {
		return $this->text;
	}

	public function getTooltipWidth() {
		return $this->tooltipWidth;
	}

	public function getBackgroundColor() {
		return $this->backgroundColor;
	}

	public function getShowAsIntro() {
		return $this->showAsIntro;
	}


}