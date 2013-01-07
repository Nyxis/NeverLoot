<?php $edit = $sf_user->isAdmin(); ?>
<div class="<?php echo $edit ? 'nl_box_tbf' : 'nl_box_tb'; ?> fiche_compo">
    <div class="nl_box_header collapser" <?php collapser('nl_compo'); ?>>
        <span class="title">Soirée du <?php echo $soiree->getDate('d/m') ?> (<?php echo $soiree->getStatus() ?>)</span>
    </div>
    <div class="nl_box_content collapsible" <?php collapsible('nl_compo'); ?>>
        <div class="nl_box_body">
            <div class="infos">
                <div class="banner" style="background-image:url('<?php echo public_path('images/raids/'.$soiree->getRaid()->getImage()); ?>');">
                    <div class="nl_box_font"><?php echo $soiree->getRaid()->getNomFr(); ?></div>
                </div>
                <div class="head nl_box_font"><?php echo $soiree->getNom(); ?></div>
                <div class="desc"><?php echo $soiree->getDescription(); ?></div>
            </div>
            <div class="calendar"></div>
            <div class="compo">
                <div class="head nl_box_font">Composition du raid</div>
                <div>
                    <?php foreach($soiree->getCompo() as $type => $infos) : ?>
                        <?php if(!empty($infos['data'])): ?>
                            <div class="role <?php echo $type ?>" type="<?php echo $type ?>">
                                <div class="nl_box_valign_wrap nl_box_font list_head">
                                    <div><?php echo image_tag($infos['img']); ?></div>
                                    <div><?php echo $infos['label'] ?></div>
                                </div>
                                <div class="inner">
                                    <?php foreach($infos['data'] as $perso) : ?>
                                        <a href="<?php echo url_for2('persoFiche', array('id_perso' => $perso->getIdPerso(), 'nom' => $perso->getNom())) ?>">
                                            <?php include_partial('perso/perso_min', array('perso' => $perso)); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php if(in_array($type, array('heal','dps', 'rpl_admin', 'refus_admin', 'absent'))): ?>
                                </div>
                                <div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php if($edit): ?>
            <div class="nl_box_footer">
                <div class="nl_box_valign_wrap">
                    <div><?php echo image_tag('pictos/edit.png', array()); ?></div>
                    <div><a href="<?php echo url_for2('raidEdit', array('id' => $soiree->getIdSoiree())); ?>">Editer</a></div>
                </div>
                <div class="nl_box_valign_wrap">
                    <div><?php echo image_tag('pictos/back.png', array()); ?></div>
                    <div><a href="#exportCompo" class="open">Exporter</a></div>
                </div>
                <?php if($soiree->getEtat() != Soiree::CLOSED): ?>
                    <div class="nl_box_valign_wrap">
                        <div><?php echo image_tag('pictos/check.png', array()); ?></div>
                        <div><a href="<?php echo url_for2('raidClose', array('id_soiree' => $soiree->getIdSoiree())); ?>">Clôturer</a></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div style="display:none;">
    <div id="exportCompo" class="nl_box_tbf popup">
        <div class="nl_box_header">
            <span class="title">Exporter la compo</span>
        </div>
        <div class="nl_box_content">
            <div class="nl_box_body">
                <textarea name="importData" id="importData" cols="57" rows="10"><?php include_partial('exportPhpBB', array('soiree'=> $soiree)); ?></textarea>
            </div>
            <div class="nl_box_footer">
                <div class="nl_box_valign_wrap">
                    <div><?php echo image_tag('pictos/back.png', array()); ?></div>
                    <div><a href="#" class="close">Retour</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
