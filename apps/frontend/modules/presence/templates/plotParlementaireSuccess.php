<?php
$debut_mandat = strtotime($parlementaire->getDebutMandat());
$debut_mandat_annee = date('Y', $debut_mandat);
$debut_mandat_sem = date('W', $debut_mandat);
if ($debut_mandat_sem == 53) {
    $debut_mandat_annee++;
    $debut_mandat_sem = 1;
}
$last_commission = strtotime($presences[0]['Seance']['date']);
$last_commission_annee = date('Y', $last_commission);
$last_commission_sem = date('W', $last_commission);
if ($last_commission_sem == 53) {
    $last_commission_annee++;
    $last_commission_sem = 1;
}
$n_weeks = ($last_commission_annee - $debut_mandat_annee)*52 + $last_commission_sem - $debut_mandat_sem + 1;
$semaines = range(1, $n_weeks);
$n_presences = array_fill(1, $n_weeks, 0);
foreach($presences as $presence) {
    $date = strtotime($presence['Seance']['date']);
    $annee = date('Y', $date);
    $sem = date('W', $date);
    if ($sem == 53) {
        $annee++;
        $sem = 1;
    }
    $n = ($annee - $debut_mandat_annee)*52 + $sem - $debut_mandat_sem + 1;
    $n_presences[$n] ++;
}
// Dataset definition
$DataSet = new xsPData;
$DataSet->AddPoint($n_presences,"Présences");
$DataSet->AddPoint($semaines,"Semaines");
$DataSet->AddSerie("Présences");
$DataSet->SetAbsciseLabelSerie("Semaines");
$DataSet->SetYAxisName("Présences");
$DataSet->SetXAxisName("Semaine");
$Test = new xsPChart(700,230);
$Test->xsSetFontProperties("tahoma.ttf",8);
$Test->setGraphArea(70,30,680,200);
$Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
$Test->drawGraphArea(255,255,255,TRUE);
$GetData = $DataSet->GetData();
$GetDataDescription = $DataSet->GetDataDescription();
$Test->drawScale($GetData,$GetDataDescription,SCALE_NORMAL,150,150,150,TRUE,0,2);
$Test->drawGrid(4,TRUE,230,230,230,50);
$Test->xsSetFontProperties("tahoma.ttf",6);
$Test->drawTreshold(0,143,55,72,TRUE,TRUE);
$Test->drawLineGraph($GetData,$GetDataDescription);
$Test->drawPlotGraph($GetData,$GetDataDescription,3,2,255,255,255);
$Test->xsSetFontProperties("tahoma.ttf",8);
$Test->drawLegend(75,35,$GetDataDescription,255,255,255);
$Test->xsSetFontProperties("tahoma.ttf",10);
$Test->drawTitle(60,22,"example 1",50,50,50,585);
$Test->xsRender("example1.png");

?>
<?php echo xspchart_image_tag('example1.png'); ?>