<?php ob_start() ?>

<style type="text/css">
.nl_box_font { font-family: Segoe UI,Arial,sans-serif; color: white }
.nl_box_valign_wrap { display:table; height:100%;}
.nl_box_valign_wrap > div { display:table-cell; vertical-align:middle; }
.fiche_compo .head { margin-bottom:10px; font-size:20px; font-weight: bold; }
.fiche_compo .banner{ height:60px; padding-top:35px; font-size: 1.1em; font-weight: bold; background-position: left bottom; background-repeat: no-repeat; margin-bottom: 10px;}
.fiche_compo .banner div{ margin-left: 30px; font-size:30px; text-shadow: 0px 0px 10px black;}
.fiche_compo a { color:white; }
.fiche_compo a:hover { color:gold; }

.chaman   	 { color:#2359FF; }
.hunt 		 { color:#AAD372; }
.deathknight { color:#C41E3B; }
.droode 	 { color:#FF7C0A; }
.warlock 	 { color:#9382C9; }
.warrior 	 { color:#C69B6D; }
.mage  		 { color:#68CCEF; }
.paladin 	 { color:#F48CBA; }
.priest 	 { color:white;   }
.rogue 	 	 { color:#FFF468; }
.monk        { color:#00FFBA; }

.perso-min {
    display:inline-block;
    height:40px;
    margin-right:5px; margin-bottom:5px;
    padding: 5px; padding-bottom: 3px;
    background: url("<?php echo image_path('ui-darkness/ui-bg_glass_30_111111_1x400.png', true); ?>") repeat-x scroll 50% 50.5% #111111;
    border: 1px solid #666666;
    font-size: 15px; line-height:16px; font-weight: bold; color: #EEEEEE;
}

.perso-min > div:first-child img { width: 37px; margin-right:3px; }

.perso-min > div+div > div:first-child { margin-bottom:2px; }
.perso-min > div+div > div+div { display: inline-block; font-size:1.1em; margin-top: 3px; color:white; }
.perso-min > div+div > div+div img { width: 16px; }

.fiche_compo .compo { margin-top:15px; }
.fiche_compo .compo .list_head { height: 42px; }
.fiche_compo .compo > div+div { display:inline-block; width: 400px; margin-right:5px; vertical-align:top; }
.fiche_compo .inner {
    margin-left:19px; margin-top: -5px; margin-bottom: 10px;
    padding-left:19px;
    border-left:1px dotted #777788;
}

.fiche_compo .inner a { font-style: normal; }

.compo .list_head { font-size: 1.2em; font-style:italic; font-weight:bold; text-decoration:underline;}
.role .list_head img { width: 40px; }
.appele .list_head img,
.absent .list_head img,
.rpl_admin .list_head img,
.refus_admin .list_head img { width: 30px; margin-left:5px; margin-right:5px; }
.compo .perso-min:hover { border:1px #0078A3 solid; color:inherit; }
.compo .list_head div+div { padding-bottom:6px; }

</style>

<div class="fiche_compo">
    <div class="banner" style="background-image:url('<?php echo image_path('raids/'.$soiree->getRaid()->getImage(), true); ?>');">
        <div class="nl_box_font"><?php echo $soiree->getRaid()->getNomFr(); ?></div>
    </div>
    <div class="head nl_box_font"><a href="<?php echo url_for2('raidFiche', array('id' => $soiree->getIdSoiree()), true) ?>" target="_blank"><?php echo $soiree->getNom(); ?></a></div>
    <div class="desc"><?php echo $soiree->getDescription() ?></div>
    <div class="compo">
        <div class="head nl_box_font">Composition du raid</div>
        <div>
            <?php foreach($soiree->getCompo() as $type => $infos) : ?>
                <?php if(!empty($infos['data']) && !in_array($type, array('refus_admin'))): ?>
                    <div class="role <?php echo $type ?>" type="<?php echo $type ?>">
                        <div class="nl_box_valign_wrap nl_box_font list_head">
                            <div><?php echo image_tag($infos['img'], array('absolute' => true)); ?></div>
                            <div><?php echo $infos['label'] ?></div>
                        </div>
                        <div class="inner">
                            <?php foreach($infos['data'] as $perso) : ?>
                                <a href="<?php echo url_for2('persoFiche', array('id_perso' => $perso->getIdPerso(), 'nom' => $perso->getNom()), true) ?>" target="_blank">
                                    <?php include_partial('perso/perso_min', array('perso' => $perso, 'absolute' => true)); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php if(in_array($type, array('heal', 'dps', 'appele'))): ?>
                        </div>
                        <div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</div>
<?php $html = addslashes(trim(preg_replace('/[\s]+/', ' ', ob_get_contents()))); ?>
<?php ob_end_clean(); ?>
$('.hidecode dd:contains(\"id\":\"raid\")').each(function(index, compoContainer) {
    $(compoContainer).parents('.hidecode').siblings('table.compo').remove();
    $(compoContainer).parents('.hidecode').after('<?php echo $html; ?>').remove();
});
