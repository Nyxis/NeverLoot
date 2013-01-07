<div class="form_wishlist">
    <?php if($edit): ?>
        <input type="hidden" name="id_wishlist" value="<?php echo $wishlist->getIdWishlist() ?>" />
    <?php endif; ?>

    <input type="hidden" name="id_perso" value="<?php echo $perso->getIdPerso(); ?>" />

    <label for="nom">Nom</label>
    <input type="text" name="nom" value="<?php echo $wishlist->getNom(); ?>" />

    <label for="id_type_wishlist">Type de wishlist</label>
    <select name="id_type_wishlist">
        <?php foreach($listeTypesWishlist as $typeWishlist) : ?>
            <option value="<?php echo $typeWishlist->getIdTypeWishlist() ?>">
                <?php echo $typeWishlist->getLibelle(); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="description">Description</label>
    <textarea name="description" id="" cols="25" rows="5"><?php echo $wishlist->getDescription(); ?></textarea>

    <label for="range_ilvl">Fourchette d'ilvl</label>
    <script type="text/javascript">
        configRange['<?php echo $edit ? $wishlist->getIdWishlist() : 'new' ?>'] = <?php echo json_encode($confIlvl); ?>
    </script>
    <div class="ilvl">
        <div>
            <span class="min"><?php echo $confIlvl['values'][0]; ?></span> &raquo;
            <span class="max"><?php echo $confIlvl['values'][1]; ?></span>
        </div>
        <div class="range_ilvl" id="<?php echo $edit ? $wishlist->getIdWishlist() : 'new' ?>"></div>
        <input type="hidden" name="ilevel_min" value="<?php echo $confIlvl['values'][0]; ?>" />
        <input type="hidden" name="ilevel_max" value="<?php echo $confIlvl['values'][1]; ?>" />
    </div>
</div>
