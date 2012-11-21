<?php
include 'autoloader.php';
use Scraper\XPathWrapper;
use Scraper\cURLWrapper;

$url = 'http://www.reddit.com/r/nosleep/top/?sort=top&t=all';
$title_query = '//p[@class="title"]/a';
$story_query = '//div[@class="expando"]/form/div[@class="usertext-body"]';
$next_query = '//p[@class="nextprev"]/a[@rel="nofollow next"]/@href';
$pages = 0;

while(++$pages < 2)
{
	$ch = new cURLWrapper($url);
	$xpath = new XPathWrapper($ch->retrieve_source());

	foreach($xpath->query($title_query) as $a)
	{
		echo '=== '.$a->nodeValue.' ==='.PHP_EOL;
		$story_ch = new cURLWrapper('http://www.reddit.com'.$a->getAttribute('href'));
		$story_xpath = new XPathWrapper($story_ch->retrieve_source());

		echo $story_xpath->query($story_query)->item(0)->nodeValue.PHP_EOL;
	}

	echo PHP_EOL;
	$url = $xpath->query($next_query)->item(0)->nodeValue;
}
