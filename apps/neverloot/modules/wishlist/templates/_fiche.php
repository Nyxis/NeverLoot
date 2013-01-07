<div class="nl_box_tbf wishlist">
    <div class="nl_box_header acc_click" <?php accordion('nl_wishlist_liste') ?>>
        <span class="title">
            Wishlist "<?php echo $wishlist->getNom(); ?>"
        </span>
    </div>

    <div class="nl_box_content acc_content" <?php accordion_target('nl_wishlist_liste') ?>>
        <div class="nl_box_body">
            <?php foreach($listeWlObjets as $class => $infos) : ?>
                <?php if(!empty($infos['data'])): ?>
                    <div class="groupeObjets <?php echo $class ?>">
                        <div class="nl_box_valign_wrap">
                            <div><?php echo image_tag('pictos/'.$infos['picto'], array()); ?></div>
                            <div class="nl_box_font"><?php echo $infos['label'] ?></div>
                        </div>
                        <div class="listeObjets">
                            <?php foreach($infos['data'] as $wlObjet) : ?>
                                <?php
                                    $slot = $wlObjet->getSlot();
                                    $objet = $wlObjet->getObjet();
                                    if (!$objet) {
                                        $objet = new Objet();
                                        $objet->setNomFr($slot->getLibelle());
                                        $objet->setImage('slots/'.$slot->getImage());
                                    }
                                ?>
                                <?php include_partial('perso/item', array(
                                    'slot' => $slot,
                                    'objet' => $objet,
                                    'itemData' => array('rel'=>$wlObjet->getIdWishlistObjet())
                                )); ?>
                            <?php endforeach; ?>
                            <div class="clear_float"></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="nl_box_footer">
            <div class="nl_box_valign_wrap">
                <div><?php echo image_tag('pictos/wl_spe1.png', array()); ?></div>
                <div><a href="#import_<?php echo $wishlist->getIdWishlist(); ?>" class="open">Importer objets</a></div>
            </div>
            <div class="nl_box_valign_wrap">
                <div><?php echo image_tag('pictos/edit.png', array()); ?></div>
                <div><a href="#edit_<?php echo $wishlist->getIdWishlist(); ?>" class="open">Editer</a></div>
            </div>
        </div>
    </div>

    <div style="display:none;">
        <div id="edit_<?php echo $wishlist->getIdWishlist(); ?>" class="nl_box_tbf popup editWishlist">
            <div class="nl_box_header">
                <span class="title">Editer une wishlist</span>
            </div>
            <form action="<?php echo url_for2('wishlistEdit', array()); ?>" method="POST">
                <div class="nl_box_content">
                    <div class="nl_box_body">
                        <?php include_component('wishlist', 'form', array(
                            'perso' => $perso,
                            'wishlist' => $wishlist,
                            'listeTypesWishlist' => $listeTypesWishlist
                        )); ?>
                    </div>
                    <div class="nl_box_footer">
                        <div class="nl_box_valign_wrap">
                            <div><?php echo image_tag('pictos/check.png', array()); ?></div>
                            <div><a href="#" class="submit">Sauvegarder</a></div>
                        </div>
                        <div class="nl_box_valign_wrap">
                            <div><?php echo image_tag('pictos/back.png', array()); ?></div>
                            <div><a href="#" class="close">Retour</a></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div style="display:none;">
        <div id="import_<?php echo $wishlist->getIdWishlist(); ?>" class="nl_box_tbf popup importWishlist">
            <div class="nl_box_header">
                <span class="title">Importer une wishlist</span>
            </div>
            <form action="<?php echo url_for2('wishlistImport', array()); ?>" method="POST">
                <div class="nl_box_content">
                    <div class="nl_box_body">
                        <input type="hidden" name="id_wishlist" value="<?php echo $wishlist->getIdWishlist(); ?>" />
                        <textarea name="importData" id="importData" cols="45" rows="10"></textarea>
                        <label for="importData">Collez ci dessus le tableau de BiS de <a href="http://www.askmrrobot.com/wow/gear" target="_blank">Askmrrobot</a>.</label>
                    </div>
                    <div class="nl_box_footer">
                        <div class="nl_box_valign_wrap">
                            <div><?php echo image_tag('pictos/wl_spe1.png', array()); ?></div>
                            <div><a href="#" class="submit">Lancer l'import</a></div>
                        </div>
                        <div class="nl_box_valign_wrap">
                            <div><?php echo image_tag('pictos/back.png', array()); ?></div>
                            <div><a href="#" class="close">Retour</a></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div style="display:none;">
        <div id="edit_wlo_<?php echo $wishlist->getIdWishlist(); ?>" class="nl_box_tbf popup editWlo">
            <div class="nl_box_header">
                <span class="title">
                    Wishlist "<?php echo $wishlist->getNom() ?>" &raquo;
                    <span class="slot"></span>
                </span>
            </div>
            <form action="<?php echo url_for2('wishlistEditObjet', array()); ?>" method="POST">
                <div class="nl_box_content">

                </div>
            </form>
        </div>
        <a href="#edit_wlo_<?php echo $wishlist->getIdWishlist(); ?>"></a>
    </div>
</div>
