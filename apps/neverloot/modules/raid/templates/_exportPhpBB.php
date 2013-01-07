<?php $colors = array(
    'chaman'      => "#2359FF",
    'hunt'        => "#AAD372",
    'deathknight' => "#C41E3B",
    'droode'      => "#FF7C0A",
    'warlock'     => "#9382C9",
    'warrior'     => "#C69B6D",
    'mage'        => "#68CCEF",
    'paladin'     => "#F48CBA",
    'priest'      => "white",
    'rogue'       => "#FFF468",
    'monk'        => "#00FFBA"
    );
 ?>
<?php ob_start(); ?>
[hide]
    <?php echo json_encode(array('id'=>'raid', 'url'=>url_for2('raidExport', array('id' => $soiree->getIdSoiree()), true))); ?>
[/hide]
[table class="compo"]
    [tr][td class="head"][url=<?php echo url_for2('raidFiche', array('id' => $soiree->getIdSoiree()), true) ?>]<?php echo $soiree->getNom(); ?>[/url][/td][/tr]
    [tr][td class="desc"]<?php echo $soiree->getDescription() ?>[/td][/tr]
    [tr][td]
        [table]
            [tr][td colspan=2 class="head"]Composition du raid[/td][/tr]
            [tr]
                <?php foreach($soiree->getCompo() as $type => $infos) : ?>
                    <?php if(!empty($infos['data']) && !in_array($type, array('refus_admin'))): ?>
                        [td]
                            [table]
                                [tr]
                                    [td][img]<?php echo image_path($infos['img'], true); ?>[/img][/td]
                                    [td class="role"]<?php echo $infos['label'] ?>[/td]
                                [/tr]
                                [tr]
                                    [td colspan=2 class="perso"]
                                    [color=white]
                                    <?php foreach($infos['data'] as $perso) : ?>
                                        [url=<?php echo url_for2('persoFiche', array('id_perso' => $perso->getIdPerso(), 'nom' => $perso->getNom()), true) ?>]
                                            [color=<?php echo $colors[$perso->getClasse()->getCode()] ?>]<?php echo htmlentities($perso->getNom(), ENT_COMPAT, 'UTF-8'); ?>[/color]
                                        [/url]
                                    <?php endforeach; ?>
                                    [/color]
                                    [/td]
                                [/tr]
                            [/table]
                        [/td]
                    <?php endif; ?>
                    <?php if(in_array($type, array('heal','appele'))): ?>
                        [/tr][tr]
                    <?php endif; ?>
                <?php endforeach; ?>
            [/tr]
        [/table]
    [/td][/tr]
[/table]
<?php $ret = trim(preg_replace('/[\s]+/', ' ', ob_get_contents())); ?>
<?php ob_end_clean(); ?>
<?php echo $ret;
