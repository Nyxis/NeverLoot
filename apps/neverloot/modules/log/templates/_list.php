<div id="logs" class="nl_box_tb">
    <div class="nl_box_header collapser" <?php collapser('nl_liste_perso'); ?>>
        <span class="title"><?php echo $title ?></span>
    </div>
    <div class="nl_box_content collapsible" <?php collapsible('nl_liste_perso'); ?>>
        <div class="nl_box_body nl_box_font">
            <div class="listePersos">
            <?php foreach($logsCollection as $index => $log): ?>
                <div class="log <?php echo ($index % 2) ? 'odd' : 'even' ?>">

                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
