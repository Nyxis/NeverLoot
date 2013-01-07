<?php $class = empty($classes) ? '' : ' '.$classes; ?>
<?php $absolute = !empty($absolute); ?>
<div class="perso-min nl_box_valign_wrap transition<?php echo $class; ?>" perso_id="<?php echo $perso->getIdPerso(); ?>" cpt_id="<?php echo $perso->getIdCompte(); ?>">
    <div><?php echo image_tag($perso->getClasse()->getImage(), array('absolute' => $absolute)); ?></div>
    <div>
        <div class="<?php echo $perso->getClasse()->getCode(); ?>">
            <?php echo htmlentities($perso->getNom(),ENT_COMPAT,'UTF-8'); ?>
        </div>
        <div>
            <?php $spe1 = $perso->getSpeRelatedByIdSpe1(); ?>
            <?php echo image_tag($spe1->getImage(), array('absolute' => $absolute)); ?>
            /
        </div>
        <div>
            <?php $spe2 = $perso->getSpeRelatedByIdSpe2(); ?>
            <?php echo image_tag($spe2->getImage(), array('absolute' => $absolute)); ?>
        </div>
    </div>
</div>
