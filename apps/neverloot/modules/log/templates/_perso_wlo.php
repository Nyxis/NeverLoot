<?php
    $user   = $sf_user->load()->getMain();
    $isMine = $perso->getIdPerso() == $user->getIdPerso();
?>

<?php if ($isMine) : ?>
    <?php echo sprintf('%s : %s a ajouté %s à sa wishlist %s.',
        date('d/m'),
        get_partial('log/perso', array('perso' => $perso)),
        get_partial('log/item', array('item' => $objet)),
        strtolower($wishlist->getTypeWishlist()->getLibelle())
    );
    ?>
<?php else: ?>
    <?php echo sprintf('%s : %s a ajouté %s à la wishlist %s de %s.',
        date('d/m'),
        get_partial('log/perso', array('perso' => $user)),
        get_partial('log/item', array('item' => $objet)),
        strtolower($wishlist->getTypeWishlist()->getLibelle()),
        get_partial('log/perso', array('perso' => $perso))
    );
    ?>
<?php endif;
