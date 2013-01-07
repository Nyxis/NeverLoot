<div class="nl_box_tbf form_soiree">
    <div class="nl_box_header collapser" <?php collapser('nl_form_raid'); ?>>
        <span class="title"><?php echo empty($title) ? 'Soirée du '.$soiree->getDate('d/m') : $title ?></span>
    </div>
    <div class="nl_box_content collapsible" <?php collapsible('nl_form_raid'); ?>>
        <form action="<?php echo url_for2('raidEditSubmit') ?>" method="POST" >
            <div class="nl_box_body">

                <input type="hidden" name="id_soiree" value="<?php echo $soiree->getIdSoiree(); ?>" />

                <label for="id_raid">Raid</label>
                <select name="id_raid">
                    <?php foreach($listeRaids as $raid) : ?>
                        <?php $selected = ($soiree->getIdRaid() == $raid->getIdRaid()) ? 'selected' : ''; ?>
                        <option value="<?php echo $raid->getIdRaid(); ?>" <?php echo $selected; ?>>
                            <?php echo $raid->getNomFr(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="nom">Nom de la soirée</label>
                <input type="text" name="nom" value="<?php echo $soiree->getNom(); ?>" />

                <label for="date">Date</label>
                <input type="text" name="date" value="<?php echo $soiree->getDate('m/d/Y'); ?>" />

                <label for="description">Description</label>
                <textarea name="description" cols="40" rows="5"><?php echo $soiree->getDescription() ?></textarea>

                <label for="gain">Gain</label>
                <input type="number" name="gain" value="<?php echo $soiree->getGain(); ?>" />

                <label for="etat">Statut soirée</label>
                <select name="etat">
                    <?php foreach($listeStatus as $idStatus => $libelleStatus) : ?>
                        <?php $selected = ($idStatus == $soiree->getEtat()) ? 'selected' : ''; ?>
                        <option value="<?php echo $idStatus; ?>" <?php echo $selected; ?>>
                            <?php echo $libelleStatus; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="nl_box_footer">
                <div class="nl_box_valign_wrap">
                    <div><?php echo image_tag('pictos/check.png', array()); ?></div>
                    <div><a href="#" class="submit">Sauvegarder</a></div>
                </div>
                <?php if(!$soiree->isNew()): ?>
                    <div class="nl_box_valign_wrap">
                        <div><?php echo image_tag('pictos/back.png', array()); ?></div>
                        <?php $url = url_for2('raidFiche', array('id'=>$soiree->getIdSoiree())); ?>
                        <div><a href="<?php echo $url; ?>">Voir fiche</a></div>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
