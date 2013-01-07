<script type="text/javascript">var configRange = {};</script>

<?php foreach($wlDisplayed as $infoComponent) : ?>
    <?php include_component('wishlist', $infoComponent['compo'], $infoComponent['params']); ?>
<?php endforeach; ?>
