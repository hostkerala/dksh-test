$(document).ready(function(){
	init_custom_forms( $(document.body) );
	
	init_ajax_navigation();
	
	init_items_controls();
	
	prevent_firefox_drag();
})

// custom forms init
function init_custom_forms( parent_node ) {
	$(parent_node).find('input:checkbox').customCheckbox();
	$(parent_node).find('input:radio').customRadio();
	//$(parent_node).find('input:file').customFile();
	$(parent_node).find('select[class!=autocomplete-combo-select]').customSelect();
}

function init_ajax_navigation(){
	// init ajax nav
	$(document).on('click', '#header nav a, #content a', function(e){
		e.preventDefault();
		
		var $this = $(this);
		if( $this.attr('href') != '#' && $this.attr('href').charAt(0) != '#' && $this.parents('div.grid-view').size() == 0 )
		{
			e.preventDefault();

			// update hash to "remember" the page
			if( $this.data('alias') )
			{
				window.location.href = window.location.href.replace(window.location.hash, '') + $this.data('alias');
			}
			
			var target = $('#content');
			if( $this.data('target') )
			{
				target = $( $this.data('target') );
			}
			ajax_load_block( target, $this.attr('href') );
		}
	});
	
	// add highlights
	$(document).on('click', '#header nav a', function(){
		var $this = $(this);
		
		$('#header nav li').removeClass('open');
		$this.parents('li').addClass('open');
	});

    // activate first subtab when clicking on tabs
    $(document).on('click', '#header .dropdown-toggle', function(){
        $(this).next().find('li:first a').click();
    });

	// load default page on load (or the one from location hash)
	if( window.location.hash != '' && $('#header nav a[data-alias=' + window.location.hash + ']').size() > 0 ){
		$('#header nav a[data-alias=' + window.location.hash + ']').click();
	}
	else{
		$('#header nav ul ul li.open a').click();
	}
	
}

function ajax_load_block( target, href, data )
{
	var type = 'GET';
	if( ! data ){
		data = {};
	}
	else{
		type = 'POST';
	}
	
	$.ajax({
		url: href,
		type: type,
		data: data,
		success: function(response){
			ajax_process( response, target );
		}
	})
}

function ajax_form_submit( form_element ){
	$(form_element).ajaxSubmit({
		success: function(response){
			// process ajax actions
			ajax_process( response, $(form_element).data('target') );
			//console.info(response);
		}
	});
}

function ajax_process( response, target ){
	
	if( typeof(response) == 'string' )
	{
		// we received html to be shown again
		$(target).html(response);

		if( $(window).scrollTop() > $(target).offset().top )
			$(window).scrollTop( Math.max( 0, $(target).offset().top-60 ) );

		init_custom_forms(target);
	}

	if( typeof(response) == 'object' ){
	
		if( response.actions ){
			
			for(var iA=0; iA<response.actions.length; iA++ ){
				var action = response.actions[iA];
				var action_type = action[0];
				
				// refresh whole page
				if( action_type == 'refreshPage' ){
					window.location.reload(true);
				}

				// replace some box html
				if( action_type == 'refreshBlock' ){
					var node = $(action[1]);
					var url = action[2];
					ajax_load_block(node, url);
				}
				
				// replace some box html
				if( action_type == 'insertHtml' ){
					var node = $(action[1]);
					$(node).html( action.content );
				}
				
				// replace some box html
				if( action_type == 'appendHtml' ){
					var node = $(action[1]);
					$(node).append( action.content );
				}
		
				// replace some box html
				if( action_type == 'replaceHtml' ){
					var node = $(action[1]);
					$(node).replaceWith( action.content );
				}
		
				// do some event
				if( action_type == 'trigger' && action.length > 2 ){
					var node = $(action[2]);
					$(node).trigger(action[1]);
				}
		
				// redirect to another page
				if( action_type == 'redirect' ){
					window.location.replace( action[1] );
					return; // break script
				}
			}
		}
		
		if( typeof(response.flash) == 'object' )
		{
			// show messages
			for( msg_type in response.flash )
			{
				//alert(response.flash[msg_type]);
				show_modal_message(msg_type, response.flash[msg_type]);
				//break;
			}
		}
	}
	//console.log(response);
}

function show_modal_message( type, message ){
	$('<p>' + message + '</p>').dialog({
		title: type + '!',
		modal: true,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});
}

function init_items_controls(){
	$(document).on('click', '#items-controls input:button', function(){
		
		if( $('#item-content table  input:checkbox:checked').size() == 0 )
		{
			//alert("No items selected.");
			show_modal_message('Error', 'No items selected.');
			return false;
		}                
		
		var ids = [];
                
		for( var i =0; i < $('#item-content table input:checkbox:checked').size(); i++ ){
			var checkbox = $('#item-content table input:checkbox:checked').get(i);
			ids.push( $(checkbox).val() );
		}
                
                //Added to show warning if "selected select all" when no items in the list //Added by Roopan - Start
                if(ids.allValuesSame())
                {
                    show_modal_message('Error', 'No items selected.');
                    return false;                    
                }
                //Added by Roopan - End
                
		var $this = $(this);
		ajax_load_block(
			$this.data('target'),
			$this.data('action'),
			{ ids: ids }
		);
	})	
}


function app_magic_suggest_change(e, m, records){
	var unique_id = $(m.container).attr('id');
	var hidden_id = '#' + unique_id + '_id';
	
	var hidden_value = 0;
	if( records.length )
	{
		hidden_value = (! isNaN( parseInt(records[0].id) ) )? records[0].id : 0;
	}
	
	$(hidden_id).val( hidden_value );
}

function prevent_firefox_drag(){
	$(document).on("dragstart", '#header *', function() {
		return false;
	});
}

function load_client_additional_fields(event, ui, value, params){
	// if we selected not new - nothing to do
	if( value == '' ){
		$(this.element).parents('div.form-wrap').find('div.client_fields')
				.hide()
				.html('');
		return;
	}
	
	// get new form
	$.ajax({
		url: params.client_ajax_url,
		data: {item_id: params.model_id, client_id: $(ui.item.option).val()},
		success: function(response){
			ajax_process( response );
		},
	})
	console.log([this, event, ui, params]);
}

/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 09-03-2015
* Time :09:51 PM
* Function to check ONLY the elemets with value "1" exists in the array
* @param $model EmailHistory
* @return boolean
*/
Array.prototype.allValuesSame = function() {

    for(var i = 1; i < this.length; i++)
    {
        if(parseInt(this[i]) !== 1)
        {
            return false;            
        }
    }
    return true;
}

$(document).ajaxSuccess(function() {
    init_custom_forms( $(document.body) );
})
