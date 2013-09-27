<div id="fiche_perso">
    <div>
        <?php include_component('perso', 'perso', array(
            'perso'      => $perso,
            'edit'       => $edit,
            'listeAcces' => $listeAcces
        )); ?>

        <?php include_component('log', 'list', array(
            'title'     => 'Activité',
            'nbLogs'    => 25,
            'tagFilter' => $perso->getTag()
        )); ?>
    </div>
    <div>
        <div class="blocWishlist">
            <?php include_component('wishlist', 'liste', array(
                'perso' => $perso
            )); ?>
        </div>
    </div>
    <br class="clear_float" />
</div>
