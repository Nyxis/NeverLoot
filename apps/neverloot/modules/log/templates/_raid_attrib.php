<?php $mod = $attrib ? '+' : '-'; ?>
<?php echo sprintf('%s : %s a %s %s à %s%s.',
    date('d/m'),
    get_partial('log/perso', array('perso' => $sf_user->load()->getMain())),
    $attrib ? 'attribué' : 'retiré',
    get_partial('log/item', array('item' => $objet)),
    get_partial('log/perso', array('perso' => $perso)),
    !empty($prix) ? ' ('.$mod.$prix.' '.image_tag('pictos/wl_spe1.png').')' : ''
);
