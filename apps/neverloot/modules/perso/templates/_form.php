<?php $edit = !empty($perso); ?>
<div class="form_perso">
    <label for="nom">Nom</label>
    <input type="text" name="nom" value="<?php echo $edit ? $perso->getNom() : ''; ?>" />

    <label for="id_classe">Classe</label>
    <select name="id_classe" class="class_select">
        <option value="-1">&nbsp;</option>
        <?php foreach($listeClasses as $classe) : ?>
            <?php $selected = ($edit && $classe->getIdClasse() == $perso->getIdClasse()) ? 'selected' : ''; ?>
            <option value="<?php echo $classe->getIdClasse(); ?>" class="<?php echo $classe->getCode(); ?>" <?php echo $selected ?>>
                <?php echo $classe->getNom(); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="specs_data" style="display:none;"><?php echo $listeSpecs; ?></div>
    <?php if($edit): ?>
        <div class="spe1" style="display:none;"><?php echo $perso->getIdSpe1(); ?></div>
        <div class="spe2" style="display:none;"><?php echo $perso->getIdSpe2(); ?></div>
    <?php endif; ?>

    <label for="id_spe1">Spe1</label>
    <select name="id_spe1" class="spec1_select"></select>

    <label for="id_spe2">Spe2</label>
    <select name="id_spe2" class="spec2_select"></select>
</div>
