<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>

        <script type="text/javascript">
            var config = {
                url: {
                    perso: "<?php echo url_for('@homepage') ?>perso/",
                    raid: "<?php echo url_for('@homepage') ?>raid/",
                    wishlist: "<?php echo url_for('@homepage') ?>wishlist/",
                    images: "<?php echo $sf_request->getRelativeUrlRoot() ?>/images/",
                    root: "<?php echo url_for('@homepage') ?>"
                }
            };
        </script>

        <?php include_javascripts() ?>
    </head>
    <body>
        <div id='global'>
            <div id='header'>
                <div id="banner"></div>
                <div id="login_info">
                    Connecté en tant que <b><?php echo $sf_user->getAttribute('login'); ?></b>
                </div>
                <div class="clear_float"></div>
            </div>

            <?php include_component('home', 'menu'); ?>

            <div id='main'>
                <div id='context'>
                    <?php include_partial('home/message', array()); ?>
                    <?php echo $sf_content; ?>
                </div>
            </div>

            <div id='footer'></div>
        </div>
        <div id="ajaxWaiter" style="display:none;"></div>
        <div id="ajaxWaiterConteneur" class="nl_box_font" style="display:none;">
            <?php echo image_tag('ajax-loader.gif'); ?><br />
            Chargement...
        </div>
    </body>
</html>
