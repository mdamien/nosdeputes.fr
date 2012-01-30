#!/usr/bin/perl

require ("../common/common.pm");
use WWW::Mechanize;
use POSIX qw<mktime strftime>;

$a = WWW::Mechanize->new();

$url = shift;
$a->get($url);
$html = $a->content;
utf8::encode($html);
$html =~ s/’/'/g;
$html =~ s/<\/[^ab][^>]*>//gi;
$html =~ s/<[^ba\/][^ba>][^>]*>//gi;
$html =~ s/(\n|<br>)/ /gi;

$html =~ s/<\/b>\s*<b>/ /gi;

$html =~ s/<\/b>/<\/b>\n/g;
$html =~ s/<b>/\n<b>/g;

sub findDate($) {
	$_ = shift;
	$_ =~ s/&[^;]+;/ /g;

	@mois = ();
	@jours = ();
	$year = '';
	$cpt = 1;

	if (/\D(2\d{3})\D/) {
		$year = $1;
	}
	while(/\D+(\d+)\D+(janvier|f[^v ]*vrier|mars|avril|mai|juin|juillet|ao[^t ]*t|septembre|octobre|novembre|d[^c ]*cembre)/gi) {
		$jours[$cpt] = $1;
		$mois[$cpt--] = $2;
	}
	if ($cpt > -1) {

		$fin = $jours[0] = $jours[1];
		$mois[0] = $mois[1];
		if (/(\d+)\D{1,10}$fin\D/) {
			$jours[0] = $1;
		}
	}

	@datesrange = sort (join('-', datize($jours[0]." ".$mois[0]." ".$year)), join('-', datize($jours[1]." ".$mois[1]." ".$year)));
	@dates =();
	
	my ( $year, $month, $day )  = split /-/, $datesrange[0];
	my ($eyear, $emonth, $eday) = split /-/, $datesrange[1];

	my $end_date   = mktime( 0, 0, 0, $eday, $emonth -1, $eyear - 1900 );
	while ( 1 ) { 
	    my $date = mktime( 0, 0, 0, $day, $month - 1, $year - 1900 );
	    ($sec, $min, $hour, $day, $month, $year, $wday, $yday) = localtime($date);
	    $year += 1900; $month += 1;
	    push @dates, sprintf("%04d-%02d-%02d", $year, $month, $day);
 	    $day++;
	    last if $date >= $end_date;
	}

	return @dates;
}

foreach (split /\n/, $html) {
	if (/^<b>/) {
		$titre = $_;
		$titre =~ s/<[^>]*>//g;
		$titre =~ s/&nbsp;/ /g;
		$titre =~ s/\s+/ /g;
		$titre =~ s/^\s*//;
		$titre =~ s/\s*$//;
		@date = findDate($_);
		next;
	}
	%id = ();
	while (/fiches_id.(\d+).asp">([^<]*)<\/a>/g) {
		$nom = $2; $id = $1;
		next if ($id{$id});
		$id{$id} = 1;
		$nom =~ s/&nbsp;/ /g;
		foreach $d (@date) {
			print "{\"nom_depute\":\"$nom\", \"id_an\":\"$id\", \"date\",\"$d\", \"url\": \"$url\", \"titre_evenement\":\"$titre\" }\n";
		}
	}
}
