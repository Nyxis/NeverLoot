<div class="nl_box_tb listePrio">
    <div class="nl_box_header collapser" <?php collapser('nl_liste_prio'); ?>>
        <span class="title">Priorités et attributions</span>
    </div>
    <div class="nl_box_content collapsible" <?php collapsible('nl_liste_prio'); ?>>
        <div class="nl_box_body">
            <?php if(empty($listePersos)): ?>

            <?php else: ?>
                <table cellspacing="0">
                    <tbody>
                    <?php foreach($listePersos as $index => $perso): ?>
                        <?php $listeLoots = $perso->getLootsForSoiree($soiree); ?>
                        <?php $nbLoots = count($listeLoots); ?>
                        <tr class="perso <?php echo ($index % 2) ? 'odd' : 'even' ?>">
                            <td class="img_classe">
                                <?php echo image_tag($perso->getClasse()->getImage()); ?>
                            </td>
                            <td class="nom">
                                <a class="<?php echo $perso->getClasse()->getCode(); ?>" href="<?php echo url_for2('persoFiche', array('id_perso' => $perso->getIdPerso(), 'nom' => $perso->getNom())) ?>" target="perso">
                                    <?php echo $perso->getNom(); ?>
                                </a>
                            </td>
                            <td class="loot">
                                <?php if($nbLoots): ?>
                                    <a href="#" rel="<?php echo $perso->getIdperso(); ?>" class="nl_box_valign_wrap">
                                        <div>(</div>
                                        <div><?php echo image_tag('pictos/wl_spe1.png'); ?></div>
                                        <div>x <?php echo $nbLoots; ?> )</div>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td class="prio">
                                ratio : <span class="ratio"><?php echo $perso->getPriorite(); ?></span>
                            </td>
                        </tr>
                        <?php if($nbLoots): ?>
                            <tr class="hidden <?php echo ($index % 2) ? 'odd' : 'even' ?>">
                                <td colspan="4" class="hidden">
                                    <div class="caddie <?php echo $perso->getIdperso() ?>" style="display:none;">
                                        <?php foreach($listeLoots as $item) : ?>
                                            <?php include_partial('perso/item', array('objet' => $item)); ?>
                                        <?php endforeach; ?>
                                        <br class="clear_float" />
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr class="hidden">
                                <td class="hidden"></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
