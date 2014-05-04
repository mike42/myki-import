#!/usr/bin/env php
<?php
/* Dump Myki CSV file to a file suitable for gnucash
	(c) Michael Billington < michael.billington@gmail.com >
	MIT Licence */
$in = fopen("php://stdin", "r");
$out = fopen("php://stdout", "w");
$err = fopen("php://stdout", "w");
$lc = 0;

while($line = fgets($in)) {
	$lc++;
	$a = str_getcsv($line, ',', '"');
	if(count($a) == 8) {
		$date = implode("-", array_reverse(explode("/", substr($a[0], 0, strpos($a[0], " ")))));
		$credit = $a[5] == "-" ? "" : $a[5];
		if($credit != "") { // Probably a top-up or reimbursement
			$description = $a[1];
		} else if($a[3] == "-") { // Probably buying myki pass
			$description = trim($a[1], "*");
		} else { // Probably travel charges
			$description = "Travel: " . $a[2] . ", Zone " . $a[3];
		}
		$debit = $a[6] == "-" ? "" : $a[6];
		$balance = $a[7] == "-" ? "" : $a[7];
		if($balance != "") { // Ignore non-charge entries
			fputcsv($out, array($date, $description, $credit == "" ? "$0.00" : $credit, $debit == ""  ? "$0.00" : $debit, $balance));
		}
	}
}
fclose($in);
fclose($out);
fclose($err);
