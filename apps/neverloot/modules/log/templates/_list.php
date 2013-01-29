<div class="logs nl_box_tb">
    <?php if ($accordion): ?>
        <div class="nl_box_header acc_click" <?php accordion($accordion); ?>>
    <?php else: ?>
        <div class="nl_box_header collapser" <?php collapser('nl_logs'); ?>>
    <?php endif; ?>
        <span class="title"><?php echo $title ?></span>
    </div>
    <?php if ($accordion): ?>
        <div class="nl_box_content acc_content" <?php accordion_target($accordion); ?>>
    <?php else: ?>
        <div class="nl_box_content collapsible" <?php collapsible('nl_logs'); ?>>
    <?php endif; ?>
        <div class="nl_box_body nl_box_font">
            <?php foreach($logsCollection as $index => $log): ?>
                <div class="log <?php echo ($index % 2) ? 'odd' : 'even' ?>">
                    <?php echo $log->getMessage(); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
