<div id="fiche_perso">
    <div>
        <div class="blocPerso">
            <?php include_component('perso', 'perso', array(
                'perso' => $perso,
                'edit' => $edit,
                'listeAcces' => $listeAcces
            )); ?>
        </div>
        <div class="blocCalendar">

        </div>
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
