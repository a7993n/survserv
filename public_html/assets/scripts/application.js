
var servers = [
	{
		name: 'Movenpick',
		endPoint: 'http://movenpick.com/server/'
	}
];

$(document).ready(function(e) {
	paint();
	$(window).resize(paint);
	/**
		Chargement de la listes des serveurs
	**/
	for(var i = 0; i < servers.length; i++){
		$('#server-dropdown').append('<li><a class="server-switcher" data-server="' + servers[i].endPoint + '">' + servers[i].name + '</a></li>');
		$('#start-server').append('<option value="' + servers[i].endPoint + '">' + servers[i].name + '</option>');
	}
	/**
		Status du serveur
	**/
	ServerStatus.useEventStream(false);
	ServerStatus.setLongPollTimeoutDelay(5000);
	ServerStatus.setBasicUserPass('px01', '12345');
	/**
		Chargement au chaud des infos
	**/
	$('.load-style a[data-load-style="polling"] input').attr('checked', 'checked');
	$('.poll-delay a[data-poll-delay="5000"] input').attr('checked', 'checked');
	/**
		Chargement event server
	**/
	$('#start-server').on('change', function(e){
		if($(this).val() == '') return;
		changeServer($("#start-server option:selected").text(), $(this).val());
	});
	$('.server-switcher').each(function(index, element) {
		$(this).click(function(e) {
			if(ServerStatus.getEndPoint() != $(this).attr('data-server')){
				changeServer($(this).html(), $(this).attr('data-server'));
			}
		});
	});
	/**
		Listen for events to change load style settings
	**/
	$('.load-style a').each(function(index, element) {
		$(this).click(function(e) {
			$('.load-style a input').attr('checked', false);
			$('.load-style a[data-load-style="' + $(this).attr('data-load-style') + '"] input').attr('checked', 'checked');
			ServerStatus.stopLoad();
			switch($(this).attr('data-load-style')){
				case 'polling':
					ServerStatus.useEventStream(false);
				break;
				case 'event':
					ServerStatus.useEventStream(true);
				break;
			}
			ServerStatus.loadData();
		});
	});
	$('.poll-delay a').each(function(index, element) {
		$(this).click(function(e) {
			$('.poll-delay a input').attr('checked', false);
			$('.poll-delay a[data-poll-delay="' + $(this).attr('data-poll-delay') + '"] input').attr('checked', 'checked');
			ServerStatus.stopLoad();
			ServerStatus.setLongPollTimeoutDelay(parseInt($(this).attr('data-poll-delay')));
			ServerStatus.loadData();
		});
	});
});

function changeServer(name, endPoint){
	if($('#start-box-container').length){
		$('#start-box-container').delay(500).hide('slow', function(){ $('#start-box-container').remove(); });
	}
	$('#selected-server').html(name);
	ServerStatus.setEndPoint(endPoint);
	ServerStatus.loadData();	
}

function paint(){
	if($(window).height() > $('body').outerHeight(true)){
		$('body').height($(window).height() - parseInt($('body').css('padding-top')));	
	}
}
