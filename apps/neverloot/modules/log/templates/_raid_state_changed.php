<?php
$raidPicto = array(
    Soiree::VALIDEE => array('label' => '<span class="valid">validé</span> la composition de', 'img' => 'pictos/check.png'),
    Soiree::ANNULEE => array('label' => '<span class="cancel">annulé</span>', 'img' => 'pictos/DeleteRed.png')
);

echo sprintf('%s : %s a %s%s la soirée %s.',
    date('d/m'),
    get_partial('log/perso', array('perso' => $sf_user->load()->getMain())),
    image_tag($raidPicto[$soiree->getEtat()]['img']),
    $raidPicto[$soiree->getEtat()]['label'],
    get_partial('log/soiree', array('soiree' => $soiree))
);
