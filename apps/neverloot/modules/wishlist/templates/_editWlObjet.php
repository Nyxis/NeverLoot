<?php
    $datasource = array();
    foreach ($listeObjets as $objet) {
        $datasource[] = sprintf('{"value": "%s", "label": "%s", "img": "%s", "ilvl": "%s", "tooltip": "%s"}',
            $objet->getIdObjet(),
            $objet->getNomFr(),
            image_path('items/'.$objet->getImage()),
            $objet->getIlevel(),
            $objet->getTooltip()
        );

        $nomEn = $objet->getNomEn();
        if(!empty($nomEn))
            $datasource[] = sprintf('{"value": "%s", "label": "%s", "img": "%s", "ilvl": "%s", "tooltip": "%s"}',
                $objet->getIdObjet(),
                $nomEn,
                image_path('items/'.$objet->getImage()),
                $objet->getIlevel(),
                $objet->getTooltip()
            );
    }

    $datasource = '['.implode(', ', $datasource).']';

    $objet = $wlObjet->getObjet();
    $isAttrib = !is_null($wlObjet->getIdAttribution());
?>
<div class="nl_box_body">
    <div class="autocomplete">
        <div id="datasource" style="display:none;" ><?php echo $datasource; ?></div>
        <input type="hidden" name="id_wishlist_objet" value="<?php echo $wlObjet->getIdWishlistObjet(); ?>" />
        <input type="hidden" name="id_objet" value="<?php echo $wlObjet->getIdObjet(); ?>" />
        <div class="nl_box_valign_wrap">
            <?php if($objet): ?>
                <div class="picto"><a href="#" rel="<?php echo $objet->getTooltip(); ?>"><?php echo image_tag('items/'.$objet->getImage(), array()); ?></a></div>
            <?php else: ?>
                <?php $slot = $wlObjet->getSlot(); ?>
                <div class="picto"><?php echo image_tag('items/slots/'.$slot->getImage(), array()); ?></div>
            <?php endif; ?>
            <div><input type="text" name="nom_objet" value="<?php echo $objet ? $objet->getNomFr() : '' ?>" /></div>
            <div><a href="#" class="open"><?php echo image_tag('down.gif'); ?></a></div>
        </div>
    </div>
    <div class="admin">
        <?php if($sf_user->isAdmin()): ?>
        <a href="#" class="open_admin"><?php echo image_tag('down.gif', array()); ?> options d'attribution</a>
        <?php endif; ?>
        <div style="display:none;">
            <label for="cost">Coût du loot</label>
            <input type="number" name="cost" value="0" />
            <input type="hidden" name="process" value="edit" />
        </div>
    </div>
</div>
<div class="nl_box_footer">
    <div class="nl_box_valign_wrap">
        <div><?php echo image_tag('pictos/check.png', array()); ?></div>
        <div><a href="#" class="submit" rel="edit">Valider</a></div>
    </div>
    <div class="nl_box_valign_wrap">
        <div><?php echo image_tag('pictos/DeleteRed.png', array()); ?></div>
        <div><a href="#" class="delete" rel="delete">Vider</a></div>
    </div>
    <div class="nl_box_valign_wrap">
    <?php if($isAttrib): ?>
        <?php if($sf_user->isAdmin()): // que les admins dans un 1er temps ?>
            <div><?php echo image_tag('pictos/corbeille.png', array()); ?></div>
            <div><a href="#" class="cancel" rel="remove">Désattribuer</a></div>
        <?php endif; ?>
    <?php elseif($objet): ?>
        <div><?php echo image_tag('pictos/wl_spe1.png', array()); ?></div>
        <div><a href="#" class="attrib" rel="add">Obtenu</a></div>
    <?php endif; ?>
    </div>
    <div class="nl_box_valign_wrap">
        <div><?php echo image_tag('pictos/back.png', array()); ?></div>
        <div><a href="#" class="close">Retour</a></div>
    </div>
</div>
