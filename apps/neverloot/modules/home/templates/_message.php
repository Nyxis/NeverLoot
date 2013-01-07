<?php if($sf_user->hasFlash('error')): ?>
    <div class="error-msg msg"><?php echo $sf_user->getFlash('error', ''); ?></div>
<?php endif; ?>

<?php if($sf_user->hasFlash('info')): ?>
    <div class="info-msg msg"><?php echo $sf_user->getFlash('info', ''); ?></div>
<?php endif;
