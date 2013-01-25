<div class="logs nl_box_tb">
    <div class="nl_box_header collapser" <?php collapser('nl_logs'); ?>>
        <span class="title"><?php echo $title ?></span>
    </div>
    <div class="nl_box_content collapsible" <?php collapsible('nl_logs'); ?>>
        <div class="nl_box_body nl_box_font">
            <?php foreach($logsCollection as $index => $log): ?>
                <div class="log <?php echo ($index % 2) ? 'odd' : 'even' ?>">
                    <?php echo $log->getMessage(); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
