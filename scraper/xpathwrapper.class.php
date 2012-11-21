<?php
namespace Scraper;

class XPathWrapper
{
	private $_html;
	private $_dom;
	private $_xpath;

	public function __construct($html, $encoding = 'utf-8')
	{
		$this->_html = $html;

		libxml_use_internal_errors();
		$this->_dom = new \DOMDocument('1.0', $encoding);
		$this->_dom->strictErrorChecking = FALSE;
		$this->_dom->recover = TRUE;
		@$this->_dom->loadHTML($html);
		libxml_clear_errors();

		$this->_xpath = new \DOMXPath($this->_dom);
	}

	public function query($query, \DOMNode $node = NULL)
	{
		return $this->_xpath->query($query, $node);
	}

	public function get_dom()
	{
		return $this->_dom;
	}
}
