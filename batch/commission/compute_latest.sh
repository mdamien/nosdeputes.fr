#!/bin/bash

source ../../bin/db.inc

mkdir -p html out presents loaded

for file in $(perl download_commission.pl $LEGISLATURE); do
    if grep "compte rendu .* sera .*é ultérieurement\|Document en attente de mise en ligne.\|La page à laquelle vous souhaitez accéder n'existe pas.\|HTTP Error 503" "html/$file" > /dev/null; then
        echo "...removing empty file $file"
        rm "html/$file"
        continue
    fi
	echo try ... ;
	perl parse_commission.pl html/$file > out/$file ;
	perl parse_presents.pl html/$file > presents/$file ;
	echo out/$file done;
done

