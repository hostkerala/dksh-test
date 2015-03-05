$(document).ready(function(){
	init_custom_forms( $(document.body) );
	
	init_popup_handlers();
});

$(window).load(function(){
	auto_open_login_popup();
})

// custom forms init
function init_custom_forms( parent_node ) {
	$(parent_node).find('input:checkbox').customCheckbox();
	//$(parent_node).find('input:radio').customRadio();
	//$(parent_node).find('input:file').customFile();
	//$(parent_node).find('select').customSelect();
}

function init_popup_handlers(){
	$(document).on('click', '#jcpopup span.close', function(){
		hide_popup();
	});
}

function auto_open_login_popup(){
	
	if( window.location.hash == '#login' ){
		$('#btn_login').click();
	}
}

function show_popup_shadow()
{
	if( $('#jcpopup_shadow').size() > 0 ) return;

	var shadow_html = '<div id="jcpopup_shadow"></div>';
	$(document.body).append(shadow_html);
	$('#jcpopup_shadow').css({
		display: 'block',
		opacity: 0.85,
		background:	'#000',
		zIndex: 1000,
		position: 'fixed',
		top: 0,
		left: 0,
		width: '100%',
		height: '100%'
	});
}

function show_popup( data )
{
	show_popup_shadow();
	// remove previous popups
	$('#jcpopup').remove();
	
	// open popup
	var popup_html = '<div id="jcpopup" class="popup">' + data + '<span class="close"></span></div>';
	$(document.body).append( popup_html );
	
	// center popup
	$('#jcpopup').css({
		zIndex:1001,
		top: ($(window).height() - $('#jcpopup').height()) / 4,
		left: '50%',
		margin: '0 0 0 -' + ($('#jcpopup').width()/2) + 'px'
	})
		
	// init forms inside the popup
	init_custom_forms( $('#jcpopup') );
}

function hide_popup(){
	$('#jcpopup_shadow').remove();
	$('#jcpopup').remove();
}

function popup_form_submit( form_element ){
	$(form_element).ajaxSubmit({
		success: function(response){
			if( typeof(response) == 'string' )
			{
				// we received html to be shown again
				show_popup(response);
			}
			else
			{
				// process ajax actions
				ajax_process( response );
			}
			console.info(response);
		}
	});
}

function ajax_process( response ){

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
				
				// open popup
				if( action_type == 'openPopup' && action.content ){
					show_popup(action.content);
				}
				
				// close popup
				if( action_type == 'closePopup' ){
					if( !action.id ) action.id = null;
					hide_popup();
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
				show_popup(response.flash[msg_type], msg_type);
				break;
			}
			//show_flash_massages(response.flash);
		}
	}
	//pa(response);
}