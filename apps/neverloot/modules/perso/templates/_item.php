<?php
    if(!isset($class)) $class = '';

    $itemData = array_merge(array(
            // 'rel' => sprintf('item=%s&amp;domain=fr', $objet->getIdObjet())
        ), empty($itemData) ? array() : $itemData
    );

    $data = '';
    foreach($itemData as $key => $value)
        $data.=sprintf(' %s="%s"', $key, $value);
?>

<div class="item transition<?php echo $class ?>" <?php echo $data; ?>>
    <?php if(isset($slot)): ?>
        <div class="slot" style="display:none;"><?php echo $slot->getLibelle(); ?></div>
    <?php endif; ?>

    <div class="nl_box_valign_wrap">
        <div class="picto">
            <a href="#" rel="<?php echo $objet->getTooltip(); ?>">
                <?php echo image_tag('items/'.$objet->getImage(), array()); ?>
            </a>
        </div>
        <div class="label"><?php echo $objet->getNomFr(); ?></div>
    </div>
</div>
