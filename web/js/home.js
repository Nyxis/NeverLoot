$(document).on('ready', function(){

	$('#menu').each(function(index, elt){

		ddsmoothmenu.init({
			mainmenuid: $(elt).attr('id'), //menu DIV id
			orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
			classname: 'ddsmoothmenu', //class added to menu's outer DIV
			//customtheme: ["#1c5a80", "#18374a"],
			contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		});

	});

    // loader ajax
    $('#ajaxWaiter').each(function(index, elt){
        $(elt).ajaxStart(function() {
            $('#ajaxWaiter').css('height', $(document).height());
            $('#ajaxWaiterConteneur').css({
                top: ($('#ajaxWaiter').innerHeight()-100)/2,
                left: ($('#ajaxWaiter').innerWidth()-150)/2
            });
            $('#ajaxWaiter, #ajaxWaiterConteneur').show();
        });

        $(elt).ajaxStop(function() {
            $('#ajaxWaiter, #ajaxWaiterConteneur').hide();
        });
    });

    // submit des forms
    $('a.submit').live('click', function(e){
        e.preventDefault();
        $(this).parents('form').submit();
    });

    // ouverture des popups
    $('a.open').fancybox({
		hideOnContentClick: false,
		padding: 0,
		overlayColor: '#000',
		scrolling: 'no',
		modal: true,
		type: 'inline'
	});

    // fermeture des popups
    $('a.close').live('click', function(e){
        e.preventDefault();
        $.fancybox.close();
    });

    // formulaire d'inscription
    $('.register_box').each(function(index, elt){
        $('input[name=login]').blur(function(){
            $('input:empty[name=nom]').attr('value', $(this).attr('value'));
        });
    })

	// form personnage
	$('.form_perso').each(function(index, elt){

		var dataSpe = $.parseJSON($(elt).find('.specs_data').html());
		// $('#specs_data').empty();

		$(elt).find('.class_select').on('change', function(e){

			var classValue = $(this).attr('value');
			if(classValue <= 0) {
				$(elt).find('.spec1_select, .spec2_select').each(function(index, elt){
					$(elt).empty();
				});
				return true;
			}

			var currentDataSpe = dataSpe[classValue];
			var html = '';
			$.each(currentDataSpe, function(index, elt){
				html += '<option value="'+elt.id+'">'+elt.nom+'</option>'
			});

			$(elt).find('.spec1_select, .spec2_select').each(function(index, elt){
				$(elt).html(html);
			});
		});

        if($(elt).find('.class_select').attr('value')) {
            $(elt).find('.class_select').trigger('change');
        }

        $(elt).find('.spe1').each(function(index, elt2){
            $(elt).find('.spec1_select > option[value='+$(elt2).html()+']').attr('selected', 'true');
        });
        $(elt).find('.spe2').each(function(index, elt2){
            $(elt).find('.spec2_select > option[value='+$(elt2).html()+']').attr('selected', 'true');
        });
	});

	// collapsing des box
	$('.nl_box_header.collapser').live('click', function(e){
		e.preventDefault();

        var collapse = $(this).next('.nl_box_content.collapsible');
        if(collapse.is(':visible')) {
            collapse.slideUp();
            $.cookie($(this).data('collapsing'), true);
        }
        else {
            collapse.slideDown();
            $.cookie($(this).data('collapsing'), null);
        }
	});

    // accordéons
    $('.nl_box_header.acc_click').live('click', function(e){
		e.preventDefault();

        var accName = $(this).data('acc_name');
        var accId = $(this).data('acc_id');

        $('.nl_box_content.acc_content[data-acc_name='+accName+']:visible').slideUp(300);
        $.cookie(accName, 0, { path: '/' }); // tous repliés

        // on déplie celui qui correspond, en le définissant comme déplié
        $(this).next('.nl_box_content.acc_content[data-acc_name='+accName+']:hidden').slideDown(300, function(){
            $.cookie(accName, accId, { path: '/' });
        });

	});
});
