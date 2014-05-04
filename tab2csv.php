#!/usr/bin/env php
<?php
/* Generate well-formed CSV from dodgy tab-delimitted data
	(c) Michael Billington < michael.billington@gmail.com >
	MIT Licence */
$in = fopen("php://stdin", "r");
$out = fopen("php://stdout", "w");
while($line = fgets($in)) {
	$a = explode("\t", $line);
	foreach($a as $key => $value) {
		$a[$key]=trim($value);
		/* Quote out ",", and escape "" */
		if(!(strpos($value, "\"") === false &&
				strpos($value, ",") === false)) {
			$a[$key] = "\"".str_replace("\"", "\"\"", $a[$key])."\"";
		}
	}
	$line = implode(",", $a) . "\r\n";
	fwrite($out, $line);
}
