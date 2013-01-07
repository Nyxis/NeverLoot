<?php slot('title_no_masthead'); ?>
    Création de compte
<?php end_slot(); ?>

<div class="nl_box_content register_box">
    <form action="<?php echo url_for2('register'); ?>" method="POST">
        <div class="nl_box_body">
            <?php include_partial('home/message', array()); ?>

            <h2>Compte</h2>

            <label for="login">Login</label>
            <input type="text" name="login" />

            <label for="password">Mot de passe</label>
            <input type="password" name="password" />

            <label for="password2">Confirmer mot de passe</label>
            <input type="password" name="password2" />

            <h2>Personnage principal</h2>
            <?php include_component('perso', 'form', array()); ?>

        </div>
        <div class="nl_box_footer">
            <div class="nl_box_valign_wrap">
                <div><?php echo image_tag('pictos/check.png', array()); ?></div>
                <div><a href="#" class="submit">Créer le compte</a></div>
            </div>
            <div class="nl_box_valign_wrap">
                <div><?php echo image_tag('pictos/back.png', array()); ?></div>
                <div><a href="<?php echo url_for2('login') ?>">Retour</a></div>
            </div>
        </div>
    </form>
</div>
