<?php
    $user   = $sf_user->load()->getMain();
    $isMine = $perso->getIdPerso() == $user->getIdPerso();

    $mod       = $attrib ? '+' : '-';
    $costLabel = !empty($prix) ? ', '.$mod.$prix.' '.image_tag('pictos/wl_spe1.png') : '';
?>

<?php if ($isMine) : ?>
    <?php echo sprintf('%s : %s %s %s (wishlist %s%s).',
        date('d/m'),
        get_partial('log/perso', array('perso' => $perso)),
        $attrib ? 'a obtenu' : 's\'est dépossédé de',
        get_partial('log/item', array('item' => $objet)),
        strtolower($wishlist->getTypeWishlist()->getLibelle()),
        $costLabel
    );
    ?>
<?php else: ?>
    <?php echo sprintf('%s : %s %s %s %s %s (wishlist %s%s).',
        date('d/m'),
        get_partial('log/perso', array('perso' => $user)),
        $attrib ? 'a attribué' : 'a dépossédé',
        get_partial('log/item', array('item' => $objet)),
        $attrib ? 'à' : 'de',
        get_partial('log/perso', array('perso' => $perso)),
        strtolower($wishlist->getTypeWishlist()->getLibelle()),
        $costLabel
    );
    ?>
<?php endif;
