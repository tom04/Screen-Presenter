<?php


class screenpresenter {

	const ALLOWED_FILES = 'png,jpg';
	const CUSTOMER_TITLE = 'Layouts';

	/** @var array */
	protected $files = array();

	protected $configFile = 'js/config_short.js';
	protected $pageTitle = 'Screen Presentation';

	/**
	 * @var string
	 */
	protected $filePath = '';

	public function setFilePath($filePath) {
		$this->filePath = $filePath;
	}

	public function setFiles(array $files) {
		foreach ($files as $file) {
			$file = $this->filePath . $file;
			$this->files[] = $file;
		}
	}

	public function setConfigFile($file) {
		$this->configFile = $file;
	}

	public function setPageTitle($title) {
		$this->pageTitle = $title;
	}

	/**
	 * Main function which outputs the template
	 *
	 * @return void
	 */
	public function run() {
		if (empty($this->files)) {
			$this->getFiles();
		}
		$template = file_get_contents('template.html');

		$marker = array(
			'###FILES###' => $this->renderFilePaths(),
			'###CONFIG_FILE###' => $this->configFile,
			'###PAGE_TITLE###' => htmlspecialchars($this->pageTitle)
		);

		$template = str_replace(array_keys($marker), array_values($marker), $template);


		echo $template;
	}

	/**
	 * Render all files
	 *
	 * @return string
	 */
	protected function renderFilePaths() {
		$content = '';
		foreach ($this->files as $file) {
			$info = @getimagesize($file);
			if (!is_array($info)) {
				throw new Exception('Image not found');
			}
			$content .= '<img src="' . htmlspecialchars($file) . '" ' . $info[3] . ' />' . chr(10);
		}

		return $content;
	}

}
