
<?php $listeAttributions = $item->getListeAttributions(); ?>
<?php $nobody = empty($listeAttributions); ?>

<div class="nl_box_body nl_box_font">
    <div class="nl_box_valign_wrap">
        <div><a href="#" rel="<?php echo $item->getTooltip(); ?>"><?php echo image_tag('items/'.$item->getImage()); ?></a></div>
        <div class="name"><?php echo $item->getNomFr(); ?></div>
        <div class="encart">
            <table><tr>
                <td class="lib">Nb Attributions : </td>
                <td class="nb">&nbsp;<?php echo $item->getNbAttributions(); ?></td>
            </tr><tr>
                <td class="lib">Nb Désenchantement : </td>
                <td class="nb">&nbsp;<?php echo 0; ?></td>
            </tr></table>
        </div>
    </div>

    <?php if($nobody): ?>
    <?php else: ?>
        <table class="liste">
            <tbody>
            <?php foreach($listeAttributions as $wishlistObjet): ?>
                <?php $perso = $wishlistObjet->getWishlist()->getPerso(); ?>
                <tr>
                    <td class="input"><input type="checkbox" name="<?php echo $wishlistObjet->getIdWishlistObjet() ?>" /></td>
                    <td class="img_role"><?php echo image_tag($perso->getSpeRelatedByIdSpe1()->getRole()->getImage()); ?></td>
                    <td class="img_classe"><?php echo image_tag($perso->getClasse()->getImage()); ?></td>
                    <td class="nom <?php echo $perso->getClasse()->getCode(); ?>"><?php echo $perso->getNom(); ?></td>
                    <td class="wlspe">(<?php echo sfInflector::humanize($wishlistObjet->getWishlist()->getTypeWishlist()->getCode()) ?>)</td>
                    <td class="loot"><?php if(!is_null($wishlistObjet->getIdAttribution())): ?><?php echo image_tag('pictos/wl_spe1.png', array()); ?><?php endif; ?></td>
                    <td class="prio">ratio : <span><?php echo $perso->getPriorite(); ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php if($sf_user->isAdmin() && !$nobody) : ?>
    <div class="nl_box_footer">
        <div class="nl_box_valign_wrap">
            <?php $urlAdd = url_for2('raidAddItem'); ?>
            <div><?php echo image_tag('pictos/check.png'); ?></div>
            <div><a href="<?php echo $urlAdd; ?>" rel="<?php echo $item->getIdObjet(); ?>" class="manage_item">Attribuer</a></div>
        </div>
        <div class="nl_box_valign_wrap">
            <?php $urlRemove = url_for2('raidRemoveItem'); ?>
            <div><?php echo image_tag('pictos/DeleteRed.png', array()); ?></div>
            <div><a href="<?php echo $urlRemove; ?>" rel="<?php echo $item->getIdObjet(); ?>" class="manage_item">Retirer</a></div>
        </div>
    </div>
<?php elseif($nobody) : ?>
    <div class="nl_box_footer">
        <div class="nl_box_valign_wrap">
            <div><?php echo image_tag('pictos/back.png'); ?></div>
            <div>Au désenchantement</div>
        </div>
    </div>
<?php endif; ?>
