<div class="<?php echo $edit ? 'nl_box_tbf' : 'nl_box_tb'; ?> infos_perso">
    <div class="nl_box_header collapser">
        <span class="title">Fiche personnage</span>
    </div>
    <div class="nl_box_content collapsible">
        <div class="nl_box_body">

            <div class="loot nl_box_font">
                <table>
                    <tr>
                        <td>Soirées de raid :</td>
                        <td>&nbsp;<?php echo $perso->getNbRaids(); ?></td>
                    </tr>
                    <tr>
                        <td>Loots en raid :</td>
                        <td>&nbsp;<?php echo $perso->getNbLoot(); ?></td>
                    </tr>
                    <tr>
                        <td>Priorité :</td>
                        <td>&nbsp;<?php echo $perso->getPriorite(); ?></td>
                    </tr>
                </table>
            </div>

            <div class="classe nl_box_valign_wrap" >
                <div><?php echo image_tag($classe->getImage()); ?></div>
                <div class="nl_box_font">
                    <div><?php echo $perso->getNom(); ?></div>
                    <div class="<?php echo $classe->getCode(); ?>">
                        <?php echo $classe->getNom(); ?>
                    </div>
                </div>
            </div>

            <div class="listeSpe">
                <?php $listeSpe = array($spe1, $spe2); ?>
                <?php foreach($listeSpe as $spe): ?>
                    <?php $role = $spe->getRole(); ?>
                    <div class="spe nl_box_valign_wrap">
                        <div><?php echo image_tag($spe->getImage()); ?></div>
                        <div>
                            <?php echo $spe->getNom(); ?>
                            <div class="nl_box_valign_wrap">
                                <div><?php echo image_tag($role->getImage()); ?></div>
                                <div><?php echo $role->getLibelle(); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="clear_float"></div>

            <?php $listePersos = $perso->getOtherPersos(); ?>
            <?php if(!empty($listePersos)): ?>
                <div class="autres_persos">
                    <div class="list_head nl_box_font">Autres personnages</div>
                    <?php foreach($listePersos as $other) : ?>
                        <a href="<?php echo url_for2('persoFiche', array('id_perso' => $other->getIdPerso(), 'nom' => $other->getNom())) ?>">
                            <div class="nl_box_valign_wrap">
                                <div><?php echo image_tag($other->getClasse()->getImage(), array()); ?></div>
                                <div><span class="<?php echo $other->getClasse()->getCode(); ?>"><?php echo $other->getNom(); ?></span></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
        <?php if($edit): ?>
            <div class="nl_box_footer">
                <div class="nl_box_valign_wrap">
                    <div><?php echo image_tag('pictos/edit.png', array()); ?></div>
                    <div><a class="open" href="#editPerso">Editer</a></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php /* ?>
<?php $listePersos = $perso->getOtherPersos(); ?>
<?php $fields = array('classe', 'nom', 'spe1', 'spe2'); ?>
<?php if(!empty($listePersos)): ?>
    <div class="nl_box_tb liste_perso_compte">
        <div class="nl_box_header collapser">
            <span class="title">Autres personnages</span>
        </div>
        <div class="nl_box_content collapsible">
            <div class="nl_box_body">

                <?php $main = array_shift($listePersos); ?>
                <?php if($main->isMain()): ?>
                    <span class="list_head nl_box_font">Main</span>
                    <ul class="main">
                        <?php include_partial('perso/elt_list', array(
                            'perso' => $main,
                            'fields' => $fields
                        )); ?>
                    </ul>
                <?php else: ?>
                    <?php array_unshift($listePersos, $main); ?>
                <?php endif; ?>

                <?php if(!empty($listePersos)): ?>
                    <span class="list_head nl_box_font">Rerolls</span>
                    <ul class="rerolls">
                    <?php foreach($listePersos as $reroll) : ?>
                        <?php include_partial('perso/elt_list', array(
                            'perso' => $reroll,
                            'fields' => $fields
                        )); ?>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php */ ?>

<?php if($edit): ?>
    <div class="nl_box_tbf new_perso">
        <div class="nl_box_header collapser">
            <span class="title">Nouveau reroll</span>
        </div>
        <div class="nl_box_content collapsible" style="display:none;">
            <form action="<?php echo url_for('@persoNew'); ?>" method="POST">
                <div class="nl_box_body">
                    <input type="hidden" name="id_compte" value="<?php echo $sf_user->load()->getIdCompte(); ?>" />
                    <?php include_component('perso', 'form', array()); ?>
                </div>
                <div class="nl_box_footer">
                    <div class="nl_box_valign_wrap">
                        <div><?php echo image_tag('pictos/new.png', array()); ?></div>
                        <div><a href="#" class="submit">Créer</a></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<div style="display:none;">
    <div id="editPerso" class="nl_box_tbf popup">
        <div class="nl_box_header">
            <span class="title">Edition personnage</span>
        </div>
        <?php $dataUrl = array('id' => $perso->getIdPerso()); ?>
        <form action="<?php echo url_for2('persoEdit', $dataUrl); ?>" method="POST">
            <div class="nl_box_content">
                <div class="nl_box_body">
                    <?php include_component('perso', 'form', array('perso' => $perso)); ?>
                    <?php if($sf_user->isAdmin()): ?>
                        <?php $compte = $perso->getCompte(); ?>
                        <label for="nb_raids">Nombre de raids</label>
                        <input type="number" name="nb_raids" value="<?php echo $compte->getNbRaids() ?>" />
                        <label for="nb_loot">Nombre de loots</label>
                        <input type="number" name="nb_loot" value="<?php echo $compte->getNbLoot() ?>" />

                        <label for="id_ref_acces">Droits d'accès</label>
                        <select name="id_ref_acces">
                            <?php foreach($listeAcces as $acces) : ?>
                                <?php $selected = ($acces->getIdRefAcces() == $compte->getIdRefAcces()) ? 'selected' : ''; ?>
                                <option value="<?php echo $acces->getIdRefAcces(); ?>" <?php echo $selected ?>>
                                    <?php echo ucfirst($acces->getCodeAcces()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    <?php endif; ?>
                </div>
                <div class="nl_box_footer">
                    <div class="nl_box_valign_wrap">
                        <div><?php echo image_tag('pictos/check.png', array()); ?></div>
                        <div><a href="#" class="submit">Sauvegarder</a></div>
                    </div>
                    <div class="nl_box_valign_wrap">
                        <div><?php echo image_tag('pictos/back.png', array()); ?></div>
                        <div><a href="#" class="close">Retour</a></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
