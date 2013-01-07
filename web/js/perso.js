$(document).on('ready', function(){

	// page d'édition des compos et des soirs de raid
	$('#fiche_perso').each(function(index, elt){
		initFichePerso();
		initListeSoirees();
		initWishlists();
	});


});

/**
 * initialise la fiche perso
 */
initFichePerso = function(){

    // slider des wishlist
    $('.range_ilvl').each(function(index, elt){
        $(this).slider(jQuery.extend({
                slide: function( event, ui ) {
                    var min = ui.values[0];
                    var max = ui.values[1];

                    $('input[name=ilevel_min]').attr('value', min);
                    $('input[name=ilevel_max]').attr('value', max);
                    $('.ilvl .min').html(min);
                    $('.ilvl .max').html(max);
                }
            }, configRange[$(this).attr('id')]
        ));
    });

    // popup d'édition
    $('.wishlist .editWlo + a').fancybox({
        hideOnContentClick: false,
        padding: 0,
        overlayColor: '#000',
        scrolling: 'no',
        modal: true,
        type: 'inline'
    });

    // modifications des objets
    $('.listeObjets .item').click(function(e){
        e.preventDefault();
        var divPopup = $(this).parents('.wishlist').find('.editWlo');
        var openPopup = $('a[href="#'+divPopup.attr('id')+'"]');

        // nom du slot
        divPopup.find('.slot').html(
            $(this).find('.slot').html()
        );

        // chargement ajax du formulaire dans la div
        $.ajax({
            url: config.url.wishlist+'editWlObjet?id_wishlist_objet='+$(this).attr('rel'),
            success: function(data, textStatus){
                divPopup.find('.nl_box_content').html(data);

                // admin
                $('.editWlo .open_admin').click(function(e){
                    e.preventDefault()
                    $(this).next().slideToggle();
                })

                // boutons de submit
                $('.editWlo a[rel]').click(function(e){
                    e.preventDefault();

                    if($(this).attr('rel') == 'delete') // on vire l'id de l'objet pour le supprimer
                        $(this).parents('.editWlo').find('input[name=id_objet]').attr('value', 0);

                    // copie de l'action à effectuer
                    $(this).parents('.editWlo').find('input[name=process]').attr('value', $(this).attr('rel'));

                    // envoi du form
                    $(this).parents('form').submit();
                });

                // lancement de l'autocomplete sur le input rendu en ajax
                var id = $('.autocomplete input[name=id_objet]');
                var name = $('.autocomplete input[name=nom_objet]');
                name.autocomplete({
                    minLength: 0,
                    source: $.parseJSON($('#datasource').html()),
                    focus: function( event, ui ) {
                        name.val( ui.item.label );
                        return false;
                    },
                    select: function( event, ui ) {
                        name.val( ui.item.label );
                        id.val( ui.item.value );
                        $('.autocomplete .picto img').attr( "src", ui.item.img );

                        return false;
                    }
                })
                .data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append(
                            '<a class="auto_list_item" rel="'+item.tooltip+'">' +
                                '<div class="nl_box_valign_wrap">' +
                                	'<div class="picto"><img src="'+ item.img +'" alt="" /></div>' +
                                    '<div class="label">' + item.label + '</div>' +
                                '</div>' +
                            '</a>'
                        )
                        .appendTo( ul );
                };

                // bouton open
                $('.autocomplete a.open').click(function(e){
                    e.preventDefault();
                    name.focus().autocomplete('search' , '');
                });

                openPopup.trigger('click');
            }
        });
    });
}

/**
 * initialise le bloc des dates
 */
initListeSoirees = function(){

}



/**
 * initialise les wishlists
 */
initWishlists = function(){

	// bind des popups
	$("a.popupImportLink").fancybox({
		hideOnContentClick: false,
		padding: 0,
		overlayColor: '#000',
		scrolling: 'no',
		modal: true,
		type: 'inline'
	});


    $('.wishlist.new a.edit').click(function(e){
        e.preventDefault();
        var bloc = $(this).parents('[id^=wishlist]');

        $.ajax($(this).attr('href'), {
			data: { wl_nom: bloc.find('input').attr('value') },
			type: 'POST',
			success: function(data, textStatus){
				bloc.html(data);
				initWishlists();
			}
		});
    });

	// lancement des formulaires d'import
	$('.importPopup a.submit').click(function(e){
		e.preventDefault();
		var type = $(this).attr('rel');
		var form = $(this).parents('.nl_box_content').find('form');

		$.ajax(form.attr('action'), {
			data: { importData: form.find('textarea').attr('value') },
			type: 'POST',
			success: function(data, textStatus){
				$('#wishlist_' + type).html(data);
				initWishlists();
				$.fancybox.close();
			}
		});
	});

}
