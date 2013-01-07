<?php slot('title_no_masthead'); ?>
    Authentification
<?php end_slot(); ?>

<?php slot('class_no_masthead'); ?>login<?php end_slot(); ?>

<div class="nl_box_content login_box">
    <form action="<?php echo url_for('@login'); ?>" method="POST">
        <div class="nl_box_body">
            <?php include_partial('home/message', array()); ?>
            <label for="login">Login</label>
            <input type="text" name="login" />

            <label for="password">Password</label>
            <input type="password" name="password" />

            <input type="hidden" name="url_redirect" value="<?php echo $sf_request->getUri(); ?>" />
            <input type="submit" style="display:none;" />
        </div>
        <div class="nl_box_footer">
            <div class="nl_box_valign_wrap">
                <div><?php echo image_tag('pictos/check.png', array()); ?></div>
                <div><a href="#" class="submit">Connexion</a></div>
            </div>
            <div class="nl_box_valign_wrap">
                <div><?php echo image_tag('pictos/new.png', array()); ?></div>
                <div><a href="<?php echo url_for('@register') ?>" class="register">Créer un compte</a></div>
            </div>
        </div>
    </form>
</div>
