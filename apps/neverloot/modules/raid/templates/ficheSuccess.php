<script type="text/javascript">
    var listeObjets = {};
    var idSoiree = <?php echo $soiree->getIdSoiree(); ?>;
</script>
<div id="fiche_raid">
    <?php include_component('raid', 'compo',       array('soiree' => $soiree)); ?>
    <?php include_component('raid', 'gestionLoot', array('soiree' => $soiree)) ?>
</div>
