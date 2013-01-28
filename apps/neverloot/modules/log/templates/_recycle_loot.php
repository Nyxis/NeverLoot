<?php echo sprintf('%s : %s a %s %s.',
    date('d/m'),
    get_partial('log/perso', array('perso' => $sf_user->load()->getMain())),
    $disenchant ? 'fait désanchanter' : 'attribué',
    get_partial('log/item', array('item' => $objet))
);
