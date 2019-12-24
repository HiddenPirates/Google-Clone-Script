<?php

class DomDocumentParser {

	private $doc;

	public function __construct($url)
	{
		$options = array(
			'http' => array(
				'method' => 'GET',
				'header' => 'User-Agent: voogleBot/0.1\n'
			)
		);

		$context = stream_context_create($options);

		$this->doc = new DomDocument();

		return @$this->doc->loadHTML(file_get_contents($url, false, $context));
	}

	public function getLinks()
	{
		return $this->doc->getElementsByTagName('a');
	}

	public function getTitleTag()
	{
		return $this->doc->getElementsByTagName('title');
	}

	public function getMeta()
	{
		return $this->doc->getElementsByTagName('meta');
	}

	public function getImages()
	{
		return $this->doc->getElementsByTagName('img');
	}

}