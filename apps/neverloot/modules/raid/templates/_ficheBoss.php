<div class="nl_box_tbf ficheBoss transition<?php if($displayHm) echo ' hm'; ?>">
    <div class="nl_box_header acc_click" <?php accordion('nl_boss_liste') ?>>
        <span class="title"><?php echo $boss->getNomFr(); ?></span>
    </div>
    <div class="nl_box_content acc_content" <?php accordion_target('nl_boss_liste', false); ?>>
        <div class="nl_box_body">
            <div class="bossBanner transition">
                <?php echo image_tag('raids/boss/'.$boss->getImage(), array('class' => $displayHm ? 'hm' : '')); ?>
            </div>
            <?php foreach($itemLists as $difficulty => $listeObjets) : ?>

                <?php if($difficulty == 'heroique'): ?>
                    <?php $display = $displayHm ? '' : 'style="display:none;"'; ?>
                <?php else: ?>
                    <?php $display = $displayHm ? 'style="display:none;"' : ''; ?>
                <?php endif; ?>

                <div class="itemList <?php echo $difficulty ?>" <?php echo $display; ?>>
                    <?php foreach($listeObjets as $item): ?>
                        <?php include_partial('perso/item', array(
                            'objet' => $item,
                            'itemData' => array('id'=>$item->getIdObjet()),
                            'class' => sprintf('%s%s',
                                ($displayHm && $item->getHeroique()) ? ' hm' : '',
                                $sf_request->hasParameter('current_item') && $sf_request->getParameter('current_item')->getIdObjet() == $item->getIdObjet()
                                    ? ' selected' : ''
                            )
                        )); ?>

                        <div class="hidden-infos" style="display:none;">
                            <?php include_partial('attribution', array(
                                'item' => $item
                            )); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="nl_box_footer">
            <div class="nl_box_valign_wrap">
                <div><?php echo image_tag('pictos/Heroic_icon.png'); ?></div>
                <div>
                    <a href="#" class="toggle" rel="normal" <?php if(!$displayHm) echo 'style="display:none;"'; ?>>Objets normaux</a>
                    <a href="#" class="toggle" rel="heroique" <?php if($displayHm) echo 'style="display:none;"'; ?>>Objets héroïques</a>
                </div>
            </div>
        </div>
    </div>
</div>
