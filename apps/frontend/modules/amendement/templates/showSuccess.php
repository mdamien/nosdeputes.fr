<div class="amendement" id="L<?php echo $amendement->texteloi_id; ?>-A<?php echo $amendement->numero; ?>">
<div class="source"><a href="<?php echo $amendement->source; ?>">source</a> - <a href="<?php echo $amendement->getLinkPDF(); ?>">PDF</a></div>
<h2><center><?php echo ($section ? link_to($titre2, '@section?id='.$section->id) : $titre2); ?> &mdash; Texte n°&nbsp;<?php echo $amendement->texteloi_id; ?></center></h2>
<h1><?php echo $titre1; ?></h1>
<div class="identiques">

</div>
<?php if ($seance || count($identiques) > 1) { ?>
<div class="seance_amendements">
  <h3><?php if ($seance) echo 'Discuté en '.link_to('séance le '.myTools::displayDate($seance['date']), '@interventions_seance?seance='.$seance['seance_id'].'#amend_'.$amendement->numero);
  $tot = count($identiques)-1;
  if ($tot > 0) {
    $ident_titre = " <small>($tot amendement";
    if ($tot > 1)
      $ident_titre .= "s identiques : ";
    else $ident_titre .= " identique : "; ?>
  <em><?php echo $ident_titre; foreach($identiques as $identique) if ($identique->numero != $amendement->numero)
      echo link_to($identique->numero, '@amendement?loi='.$identique->texteloi_id.'&numero='.$identique->numero)." "; ?>)</em></small>
  <?php } ?></h3>
</div>
<?php } ?>
<?php if ($sous_admts) { ?>
<p>Sous-amendements associés&nbsp: <?php foreach($sous_admts as $sous) {
    if ($sous['sort'] === 'Adopté') echo '<strong>';
    echo link_to($sous['numero'], '@amendement?loi='.$amendement->texteloi_id.'&numero='.$sous['numero']).' ';
    if ($sous['sort'] === 'Adopté') echo '(Adopté)</strong> ';
  } ?></p>
<?php } ?>
<p>Déposé le <?php echo myTools::displayDate($amendement->date); ?> par : <span id="liste_deputes"><?php echo preg_replace('/(M[.mle]+)\s+/', '\\1&nbsp;', $amendement->getSignataires(1)); ?>.</span></p>
<div class="signataires">
  <div class="photos"><p>
<?php $deputes = $amendement->Parlementaires;
  include_partial('parlementaire/photos', array("deputes" => $deputes)); ?>
  </p></div>
</div>
<div class="sujet">
  <h3><?php $sujet = $amendement->getSujet();
    if ($titreloi && preg_match('/^(.*)?(art(\.|icle)\s*)((\d+|premier).*)$/i', $sujet, $match)) {
      $art = preg_replace('/premier/i', '1er', $match[4]);
      $art = strtolower(preg_replace('/\s+/', '-', $art));
      $sujet = $match[1].link_to($match[2].$match[4], '@loi_article?loi='.$titreloi->texteloi_id.'&article='.$art);
    }
    if ($titreloi)
      echo link_to(preg_replace('/(Simplifions la loi 2\.0 : )?(.*)\s*<br.*$/', '\2', $titreloi->titre), '@loi?loi='.$titreloi->texteloi_id);
    else if ($loi)
      echo link_to($loititle, '@document?id='.$loi->id);
    else echo $loititle;
    echo '</h3><h3>'.$sujet;
    if ($l = $amendement->getLettreLoi()) echo "($l)"; ?></h3>
</div>
<div class="texte_intervention">
  <?php $texte = $amendement->getTexte();
  if ($titreloi && preg_match('/alin..?a(s)?\D\D?(\d+)[^\d]/', $texte, $match)) {
    $link = link_to('alinéa'.$match[1].' '.$match[2], '@loi_article?loi='.$titreloi->texteloi_id.'&article='.$art.'#alinea_'.$match[2]);
    $texte = preg_replace('/(alin..?as?\D\D?\d+)([^\d])/', $link.'\2', $texte);
  }
  echo myTools::escape_blanks($texte); ?>
</div>
<?php if (isset($amendement->expose)) { ?>
  <h3>Exposé sommaire :</h3>
  <div class="expose_amendement">
    <?php echo myTools::escape_blanks($amendement->getExpose()); ?>
  </div>
<?php } ?>
<div class="commentaires">
<?php echo include_component('commentaire', 'showAll', array('object' => $amendement, 'type' => 'cet amendement'));
echo include_component('commentaire', 'form', array('object' => $amendement)); ?>
</div>
</div>
<script type="text/javascript">
<!--
$('#liste_deputes a').bind('mouseover', function() {
 var nom = $(this).attr('href');
 nom = nom.replace(/^.*rechercher\/([A-ZÉ][\.\s]+)*/, '');
 $('.photo_fiche').css('opacity', '0.3');
 $('.photo_fiche[title*="'+nom+'"]').css('opacity', '1');
});
$('#liste_deputes').bind('mouseout', function() {
 $('.photo_fiche').css('opacity', '1');
});
// -->
</script>
