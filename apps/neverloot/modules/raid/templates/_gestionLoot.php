<?php if(!empty($listeBoss)): ?>
    <div class="gestion_loot">

        <?php // liste des boss ?>
        <?php $listePersos = $soiree->getListeConfirmes(); ?>
        <div class="listeBoss">
            <?php foreach($listeBoss as $boss): ?>
                <?php include_component('raid', 'ficheBoss', array(
                    'listePersos' => $listePersos,
                    'boss'        => $boss,
                    'id_objet'    => isset($id_objet) ? $id_objet : null
                )); ?>
            <?php endforeach; ?>
        </div>

        <div class="listePersos">
            <?php // flux d'activité de la soirée ?>
            <?php include_component('log', 'list', array(
                'title'     => 'Activité',
                'tagFilter' => $soiree->getTag(),
                'accordion' => 'liste_prio'
            )); ?>

            <?php // liste des attributions ?>
            <?php include_component('perso', 'listePrio', array(
                'listePersos' => $listePersos,
                'soiree'      => $soiree
            )); ?>

            <?php // placeholder pour les attributions des objets ?>
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
