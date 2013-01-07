
<div class="nl_box_tb edit_compo">
    <div class="nl_box_header collapser">
        <span class="title">Composition du raid</span>
    </div>
    <div class="nl_box_content collapsible">
        <div class="nl_box_body compo">
            <?php foreach($compo as $type => $infos) : ?>
                <div class="role <?php echo $type ?>" type="<?php echo $type ?>">
                    <div class="nl_box_valign_wrap nl_box_font list_head">
                        <div><?php echo image_tag($infos['img']); ?></div>
                        <div><?php echo $infos['label'] ?></div>
                    </div>
                    <div class="inner">
                        <div class="droppable">
                            <?php if(!empty($infos['data'])): ?>
                                <?php foreach($infos['data'] as $perso) : ?>
                                    <?php include_partial('perso/perso_min', array('perso' => $perso)); ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
