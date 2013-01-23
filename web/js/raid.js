//---------------------------------------------------------------
// formulaires de soirées
//---------------------------------------------------------------

/**
 * contructeur des actions sur le formulaire des soirées de raid
 * @param mixed blocForm bloc parent contenant le formulaire
 */
initRaidForm = function(blocForm) {
    var $blocForm = $(blocForm);

    // calendrier sur le champ de date
    $blocForm.find('input[name=date]').datepicker({
        dateFormat: 'yy-mm-dd'
    });

}

//---------------------------------------------------------------
// gestionnaire de compositions de raid
//---------------------------------------------------------------

/**
 * fonction d'initialisation du formulaire de compos
 */
initCompoForm = function(){

    $('.perso a').click(function(e){
        e.preventDefault();

        $(this).parent().next('.rerolls:hidden').show('slide', { direction: 'left' }, 300, function(){
            $(this).css('display','inline-block');
            $(this).parent('.perso').find('.perso-min').addClass('focus');
        });

        $('.perso a').parent().next('.rerolls:visible').hide('slide', { direction: 'left' }, 300, function(){
            $(this).parent('.perso').find('.perso-min').removeClass('focus');
        });
    });

	// gestion drag and drop des joueurs
    $('.perso-min').draggable({
        helper: "clone",
        appendTo: "body"
    });

    // dans la compo
    $('.droppable').droppable({
        activeClass: "focus",
        accept: '.perso-min',
        drop: function( event, ui ) {
            var content = $(this);
            var item = $(ui.draggable);

			$('.droppable .perso-min[cpt_id='+item.attr('cpt_id')+']').remove();

			item = item.clone().removeClass('focus').draggable({
				helper: "clone",
				appendTo: "body"
			});

            // ajout de l'objet au conteneur
            item.appendTo(content);
            item.css('border-color','gold');
        }
    });

    // hors de la compo
    $('.cancel').droppable({
        accept: '.perso-min',
        drop: function( event, ui ) {
            $(ui.draggable).remove();
        }
    });


	// submit du formulaire
	$('.form_soiree form').submit(function(e){

		// récupère tous les persos dans la compo, groupés par role puis
		// les passe en json dans le champ caché
		var jsonString = '{';

		$('.edit_compo .role').each(function(index, elt){
			if(index > 0) jsonString += ', ';
			jsonString += '"'+ $(elt).attr('type') + '":[';

			$(elt).find('.perso-min').each(function(index, elt){
				if(index > 0) jsonString += ',';
				jsonString += $(elt).attr('perso_id');
			});

			jsonString += ']';
		});

		jsonString += '}';

		$('<input type="hidden" name="compojson" />').attr('value', jsonString)
            .appendTo(this);
	});
}

//---------------------------------------------------------------
// fiche soirée
//---------------------------------------------------------------

/**
 * initialisation de la fiche soirée
 * calendar et handlers ajax de gestion de loots
 */
initFicheSoiree = function(){

	$(".calendar").datepicker();

    initGestionLoot();
}


// variables utilisées pour stocker les objets attribués
var idAttrib = 1;
var attributions = [];

/**
 * fonction d'init de la gestion des loots
 */
initGestionLoot = function() {

    // chargement des listes de persos
    $(".ficheBoss .item").live('click', function(e) {
        e.preventDefault();

        // graphismes
        $(".ficheBoss .item").removeClass('selected');
        $(this).addClass('selected');

        // construction de la liste
        buildListeAttrib($(this).attr('id'));

        $('.listePersosObjet').hide().show('slide', { direction: 'left' }, 300);
    });

    // switch hm / nm
    $('.ficheBoss .toggle').live('click', function(e){
        e.preventDefault();
        var $ficheBoss = $(this).parents('.ficheBoss');
        var other = $(this).attr('rel') == 'heroique' ? 'normal' : 'heroique';

        $ficheBoss.find('.itemList.'+other).hide();
        $ficheBoss.find('.itemList.'+$(this).attr('rel')).show('slide', { direction: 'right' }, 300, function(){
            $ficheBoss.toggleClass('hm')
                .find('.bossBanner img, .heroique .item').toggleClass('hm');
        });

        $ficheBoss.find('a.toggle[rel="'+other+'"]').show();
        $(this).hide();
    })

    // liens d'attribution et de retrait
    $('a.manage_item').live('click', function(e) {
        e.preventDefault();

        var listIdWlObjet = "[";
        $(this).parents('.nl_box_content').find('input:checked').each(function(index, e){
            if(index > 0) listIdWlObjet += ',';
            listIdWlObjet += $(e).attr('name');
        });
        listIdWlObjet += "]";

        var idObjet = $(this).attr('rel');

        $.ajax($(this).attr('href'), {
            type: "POST",
            data: {
                "liste_id_wl_objet": listIdWlObjet,
                "id_soiree": idSoiree,
                "id_objet" : $(this).attr('rel')
            },
            success: function(data) {
                $('.gestion_loot').after(data).remove();
                buildListeAttrib(idObjet);
                $('.listePersosObjet').show();
            }
        });
    });

    // gestion de l'accordeon de la liste des loots
    $('.listePrio a').live('click', function(e){
		e.preventDefault();
        $('.listePrio .caddie:visible').slideUp();
        $(this).parents('table').find('.' + $(this).attr('rel') + ':hidden').slideDown();
	});
}

/**
 * construit la liste des attribs pour l'id objet en paramètre
 * @param string id objet
 */
buildListeAttrib = function(itemId) {

    // écriture des données objets
    $('.attribution .nl_box_content').html(
        $('#' + itemId).next('.hidden-infos').html()
    );

}

//---------------------------------------------------------------
// execution
//---------------------------------------------------------------
$(document).on('ready', function(){

    // formulaire de gestion des soirées de raid
    $('.form_soiree').each(function(index, elt){
        initRaidForm(elt);
    });

    // gestionnaire de compo
    $('#edit_raid').each(function(index, elt){
		initCompoForm();
	});

    // fiche soirée
    $('#fiche_raid').each(function(index, elt){
		initFicheSoiree();
	});

});
