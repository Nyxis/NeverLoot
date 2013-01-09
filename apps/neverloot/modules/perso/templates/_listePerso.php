<?php $edit = $sf_user->isAdmin(); ?>
<div id="roster" class="<?php echo $edit ? 'nl_box_tbf' : 'nl_box_tb'; ?>">
    <div class="nl_box_header collapser" <?php collapser('nl_liste_perso'); ?>>
        <span class="title"><?php echo $title ?></span>
    </div>
    <div class="nl_box_content collapsible" <?php collapsible('nl_liste_perso'); ?>>
        <div class="nl_box_body nl_box_font">
            <div class="listePersos">
            <?php foreach($listePerso as $index => $perso): ?>
                <?php $compte = $perso->getCompte(); ?>
                <div class="perso <?php echo $perso->isMain() ? 'main' : 'reroll'?> <?php echo ($index % 2) ? 'odd' : 'even' ?>">
                    <div>
                        <?php if($edit && $perso->isMain()): ?>
                            <input type="checkbox" />
                        <?php endif; ?>
                    </div>

                    <a class="nl_box_valign_wrap" href="<?php echo url_for2('persoFiche', array('id_perso' => $perso->getIdPerso(), 'nom' => $perso->getNom())) ?>">
                        <div><?php echo image_tag($perso->getClasse()->getImage()); ?></div>
                        <div>
                            <div class="<?php echo $perso->getClasse()->getCode(); ?>"><?php echo $perso->getNom(); ?></div>
                            <div><?php echo $perso->getClasse()->getNom(); ?></div>
                        </div>
                    </a>

                    <?php $listeSpe = array($perso->getSpe1(), $perso->getSpe2()); ?>
                    <?php foreach($listeSpe as $spe): ?>
                        <?php $role = $spe->getRole(); ?>
                        <div class="spe nl_box_valign_wrap">
                            <div><?php echo image_tag($spe->getImage()); ?></div>
                            <div>
                                <?php echo $spe->getNom(); ?>
                                <div class="nl_box_valign_wrap">
                                    <div><?php echo image_tag($role->getImage()); ?></div>
                                    <div><?php echo $role->getLibelle(); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if($perso->isMain()): ?>
                        <div class="soirees"><?php echo $compte->getNbRaids();?> soirs</div>
                        <div class="loot"><?php echo $compte->getNbLoot();?> loots</div>
                        <div class="prio">ratio : <span class="ratio"><?php echo $compte->getPriorite();?></span></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if($edit): ?>
            <div class="nl_box_footer">
                <div class="nl_box_valign_wrap">
                    <div><?php echo image_tag('pictos/DeleteRed.png', array()); ?></div>
                    <div><a class="open" href="#editPerso">Supprimer</a></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
