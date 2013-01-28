<div id="home">
    <div class="home_text nl_box_tb">
        <div class="nl_box_header">
            <span class="title">Bienvenue sur NeverLoot !</span>
        </div>
        <div class="nl_box_content">
            <div class="nl_box_body nl_box_font">
                <p>Cette application a pour but de simplifier la gestion des compositions de raid et des attributions de butin.</p>
                <p>Pour se faire, le système a besoin que chaque membre remplisse leurs wishlists pour mains et rerolls raiders.</p>
                <p>Seront ensuite disponibles les listes de butin par boss, et les priorités d'attributions par objets et par membre.</p>
                <p>En vous remerciant par avance, rendez vous en raid !</p>
            </div>
        </div>
    </div>

    <?php include_component('perso', 'board', array()); ?>

    <?php include_component('log', 'list', array(
        'title'     => 'Activité',
        'nbLogs'    => 50,
        'codeFilters' => array('raid_attrib', 'recycle_loot', 'raid_state_changed', 'raid_close')
    )); ?>
</div>
