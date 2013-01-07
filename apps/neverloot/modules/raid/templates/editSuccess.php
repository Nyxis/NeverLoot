<div id="edit_raid">
    <div>
        <?php include_component('raid', 'listeInscrits', array('soiree' => $soiree)); ?>
        <?php include_component('raid', 'form', array('soiree' => $soiree)); ?>
    </div>
    <div>
        <?php include_component('raid', 'editCompo', array('soiree' => $soiree)); ?>
    </div>
    <br class="clear_float" />
</div>
