
<div class="nl_box_tb inscrits">
    <div class="nl_box_header collapser">
        <span class="title">Membres du raid</span>
    </div>
    <div class="nl_box_content collapsible">
        <div class="nl_box_body cancel">
            <?php foreach($listeInscrits as $perso) : ?>
                <div class="perso">
                    <div class="main">
                        <?php include_partial('perso/perso_min', array('perso' => $perso)); ?>
                    </div><?php $listeRerolls = $perso->getCompte()->getRerolls();
                        if (!$listeRerolls->isEmpty()) : ?><div class="open">
                            <a href="#" class="nl_box_valign_wrap">
                                <div><?php echo image_tag('pictos/fleches.png', array()); ?></div>
                            </a>
                        </div>
                        <div class="rerolls" style="display:none;">
                            <?php foreach($listeRerolls as $reroll) : ?>
                                    <?php include_partial('perso/perso_min', array('perso' => $reroll)); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <br class="clear_float" />
        </div>
    </div>
</div>
