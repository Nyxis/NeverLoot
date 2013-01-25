<?php $main = $sf_user->load()->getMain(); ?>
<div class="board nl_box_tb">
    <div class="nl_box_header">
        <span class="title">
            Résumé -
            <span class="<?php echo $main->getClasse()->getCode(); ?>">
                <?php echo $main->getNom(); ?>
            </span>
        </span>
    </div>
    <div class="nl_box_content">
        <div class="nl_box_body nl_box_font">

        </div>
    </div>
</div>
