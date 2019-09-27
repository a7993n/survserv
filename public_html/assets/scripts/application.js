
var servers = [
	{
		name: 'Movenpick',
		endPoint: 'movenpick.com/server/'
	}
];

$(document).ready(function(e) {
	paint();
	$(window).resize(paint);
	/**
		Fill server switchers with available servers
	**/
	for(var i = 0; i < servers.length; i++){
		$('#server-dropdown').append('<li><a class="server-switcher" data-server="' + servers[i].endPoint + '">' + servers[i].name + '</a></li>');
		$('#start-server').append('<option value="' + servers[i].endPoint + '">' + servers[i].name + '</option>');
	}
	/**
		Setup ServerStatus
	**/
	ServerStatus.useEventStream(false);
	ServerStatus.setLongPollTimeoutDelay(5000);
	ServerStatus.setBasicUserPass('BASIC_AUTH_USERNAME', 'BASIC_AUTH_PASSWORD');
	/**
		Update view to reflect default ServerStatus load settings
	**/
	$('.load-style a[data-load-style="polling"] input').attr('checked', 'checked');
	$('.poll-delay a[data-poll-delay="5000"] input').attr('checked', 'checked');
	/**
		Listen for events to change server
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
