<?php

class screenpresenter {

	const ALLOWED_FILES = 'png,jpg';
	const CUSTOMER_TITLE = 'Layouts';

	/** @var array */
	protected $files = array();

	/**
	 * Main function which outputs the template
	 *
	 * @return void
	 */
	public function run() {
		$this->getFiles();
		$template = file_get_contents('template.html');

		$search = array('###FILES###');
		$replace = array($this->renderFilePaths());
		$template = str_replace($search, $replace, $template);


		echo $template;
	}

	/**
	 * Get all giles from the screens directory
	 *
	 * @return void
	 */
	protected function getFiles() {
		$path = __DIR__ . '\screens/';
		$allowedFileTypes = explode(',', self::ALLOWED_FILES);

		$files = array();
		$handle = opendir($path);
		while ($fileName = readdir($handle)) {
			$file = $path . $fileName;
			if (filetype($file) !== 'file') {
				continue;
			}
			$fileInformation = pathinfo($file);
			if (!in_array($fileInformation['extension'], $allowedFileTypes)) {
				continue;
			}
			$files[] = 'screens/' . $fileName;
		}

		$this->files = $files;
	}

	/**
	 * Render all files
	 *
	 * @return string
	 */
	protected function renderFilePaths() {
		$content = '';
		foreach ($this->files as $file) {
			$content .= '<img src="' . htmlspecialchars($file) . '" />';
		}

		return $content;
	}

}


$instance = new screenpresenter();
$instance->run();