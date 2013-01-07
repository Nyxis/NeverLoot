<div class="nl_box_tbf new_wishlist">
    <div class="nl_box_header collapser">
        <span class="title">Nouvelle Wishlist</span>
    </div>
    <div class="nl_box_content collapsible" style="display:none;">
    <form action="<?php echo url_for('@wishlistEdit'); ?>" method="POST">
        <div class="nl_box_body">
            <?php include_component('wishlist', 'form', array(
                'perso' => $perso,
                'wishlist' => $wishlist,
                'listeTypesWishlist' => $listeTypesWishlist
            )); ?>
        </div>
        <div class="nl_box_footer">
            <div class="nl_box_valign_wrap">
                <div><?php echo image_tag('pictos/new.png', array()); ?></div>
                <div><a href="#" class="submit">Créer</a></div>
            </div>
        </div>
    </form>
</div>
</div>
