#!/usr/bin/perl

use WWW::Mechanize;
use HTML::TokeParser;
$count = 0;
$legislature = shift || 14;
$loi = shift;

$url = "http://recherche2.assemblee-nationale.fr/amendements/resultats.jsp?typeEcran=avance&chercherDateParNumero=non&NUM_INIT=".$loi."&NUM_AMEND=&AUTEUR=&DESIGNATION_ARTICLE=&DESIGNATION_ALINEA=&SORT_EN_SEANCE=&DELIBERATION=&NUM_PARTIE=&DateDebut=&DateFin=&periode=&LEGISLATURE=".$legislature."Amendements&QueryText=&Scope=TEXTEINTEGRAL&SortField=ORDRE_TEXTE&SortOrder=Asc&format=HTML&ResultCount=5000&searchadvanced=Rechercher";
$a = WWW::Mechanize->new();
$a->get($url);
$content = $a->content;
$p = HTML::TokeParser->new(\$content);
open FILE, ">:utf8", "liasse_order.tmp";
	
while ($t = $p->get_tag('a')) {
    if ($t->[1]{class} eq 'lienamendement') {
	$htmfile = $t->[1]{href};
	next if ($htmfile =~ /(index|javascript)/);
	if ($htmfile =~ /(\d{4}.|amendements\/\d{1,4}\/[A-Z_\-]+\/)(\d{1,4})\.asp/) {
	    $num = $2;
	    $num =~ s/^0*//;
	    print FILE $num."\n";
	    $count++;
	}
    }
}
close FILE;
print $count." amendements pour la loi ".$loi."\n";

