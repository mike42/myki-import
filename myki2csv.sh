#!/bin/bash
# Convert myki history from PDF to CSV
#	(c) Michael Billington < michael.billington@gmail.com >
#	MIT Licence
hash pdftotext || exit 1
hash unexpand || exit 1
pdftotext -layout -nopgbrk $1 - | \
	grep "^[0-3][0-9]/[0-9][0-9]/[0-9][0-9][0-9][0-9] [0-9][0-9]:[0-9][0-9]:[0-9][0-9] *T" | \
	unexpand -t2 | \
	tr -s '\t' | \
	./tab2csv.php > ${1%.pdf}.csv
