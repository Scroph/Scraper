<?php
namespace Scraper;

class cURLWrapper
{
	private $_url;
	private $_ch;
	private $_opts;

	public function __construct($url)
	{
		if(!filter_var($url, FILTER_VALIDATE_URL))
		{
			throw new Exceptions\cURLException($url.' is not a valid URL.');
		}

		$this->_url = $url;
		$this->_ch = curl_init($url);

		curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, TRUE);
	}

	public function set($attr, $val)
	{
		$this->_opts[$attr] = $val;
		$attr = strtoupper($attr);
		curl_setopt($this->_ch, constant('CURLOPT_'.$attr), $val);
		
		return $this;
	}

	public function get_handle()
	{
		return $this->_ch;
	}

	public function retrieve_source($write_to = NULL)
	{
		$result = curl_exec($this->_ch);
		if($result === FALSE)
		{
			throw new Exceptions\cURLException(curl_error($this->_ch));
		}

		if($write_to !== NULL)
		{
			if(file_put_contents($write_to, $result) === FALSE)
			{
				throw new Exceptions\IOException('Failed to write to : '.$write_to);
			}
		}
		return $result;
	}

	public function retrieve_details($type = NULL)
	{
		$constant = $type !== NULL ? constant(strtoupper('CURLINFO_'.$type)) : 0;
		return curl_getinfo($this->_ch, $constant);
	}

	public function close()
	{
		curl_close($this->_ch);
	}

	public function __destruct()
	{
		is_resource($this->_ch) && $this->close();
	}
}
