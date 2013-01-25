<?php if(!empty($listeBoss)): ?>
    <div class="gestion_loot">
        <?php include_component('log', 'list', array('title' => 'Activité', 'tagFilter' => $soiree->getTag())); ?>
        <?php $listePersos = $soiree->getListeConfirmes(); ?>
        <div class="listeBoss">
            <?php foreach($listeBoss as $boss): ?>
                <?php include_component('raid', 'ficheBoss', array(
                    'listePersos' => $listePersos,
                    'boss' => $boss,
                    'id_objet' => isset($id_objet) ? $id_objet : null
                )); ?>
            <?php endforeach; ?>
        </div>
        <div class="listePersos">
            <?php include_component('perso', 'listePrio', array(
                'listePersos' => $listePersos,
                'soiree' => $soiree
            )); ?>
            <div class="listePersosObjet" style="display:none;">
                <div class="nl_box_tbf attribution">
                    <div class="nl_box_header">
                        <span class="title">Attribution d'objet</span>
                    </div>
                    <div class="nl_box_content"></div>
                </div>
            </div>
        </div>
        <br class="clear_float" />
    </div>
<?php endif;
