<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />

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

    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id='global_no_masthead' class="nl_box_tbf <?php echo get_slot('class_no_masthead') ?>">
        <div class="nl_box_header">
            <?php $titre = get_slot('title_no_masthead', ''); ?>
            <span class="title">
                NeverLoot <?php echo empty($titre) ? '' : '&raquo; '.$titre ?>
            </span>
        </div>
        <?php echo $sf_content ?>
    </div>
  </body>
</html>
