<ul>
    <?php foreach($listeElements as $elt) : ?>

        <?php // autorisation pour voir le lien ?>
        <?php if(isset($elt['credential']) && !$sf_user->hasCredential($elt['credential'])) continue; ?>

        <?php // cible du lien ?>
        <?php if(isset($elt['route'])): ?>
            <?php $lien = url_for2($elt['route'], !empty($elt['params']) ? $elt['params'] : array()); ?>
        <?php else: ?>
            <?php $lien = '#'; ?>
        <?php endif; ?>

        <?php // label ?>
        <?php $label = !empty($elt['img']) ? '&nbsp;'.image_tag($elt['img']).'&nbsp;' : $elt['txt']; ?>

        <li>
            <a href="<?php echo $lien ?>"><?php echo $label; ?></a>
            <?php if(!empty($elt['children'])): ?>
                <?php include_partial('home/niveau_menu', array('listeElements' => $elt['children'])); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
