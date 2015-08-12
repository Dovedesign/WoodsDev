jQuery(document).ready(function($){
	
	// Tabs del Panel de Opciones
	$(".pps-tab-content").hide(); //Hide all content
	$("#pps-tabs a:first").addClass("nav-tab-active").show(); //Activate first tab
	$(".pps-tab-content:first").show(); //Show first tab content
	
	$("#pps-tabs a").click(function() {
		$("#pps-tabs a").removeClass("nav-tab-active"); //Remove any "active" class
		$(this).addClass("nav-tab-active"); //Add "active" class to selected tab
		$(".pps-tab-content").removeClass("active").hide(); //Remove any "active" class and Hide all tab content
		var activeTab = $(this).attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn().addClass("active"); //Fade in the active content
		return false;
	});
	
	
	// Elimina elementos no deseados
	if($('.wp-list-table tr.type-popuppress').length){
		$('tr.type-popuppress').find('td .row-actions span.view').remove();
	}
	if($('.pps_metabox').length) {
		$('#edit-slug-box, #preview-action').remove();
	}
	
	
	/*// Oculta y Muestra Opciones Avanzadas del MetaBox
	$(".pps-toggle-fields").toggle(function (){
    	$(this).closest('.pps-row').nextAll().css('visibility', 'visible');
		$(this).text("Hide");
    }, function(){
    	$(this).closest('.pps-row').nextAll().css('visibility', 'collapse');
		$(this).text("Show");
	});*/
	
	// OCULTA/MUESTRA CAMPO "Open Delay"
	checkActiveBox_pps('input#pps_auto_open1', '.cpmb_id_pps_delay');
	
	$('input[name="pps_auto_open"]').click(function() {
		checkActiveBox_pps('input#pps_auto_open1', '.cpmb_id_pps_delay');
	});
	
	// OCULTA/MUESTRA CAMPO "Close Delay"
	checkActiveBox_pps('input#pps_auto_close1', '.cpmb_id_pps_delay_close');
	
	$('input[name="pps_auto_close"]').click(function() {
		checkActiveBox_pps('input#pps_auto_close1', '.cpmb_id_pps_delay_close');
	});
	
	// OCULTA/MUESTRA CAMPO "Exclude Pages"
	checkActiveBox_pps('input#pps_open_in3', '.cpmb_id_pps_exclude_pages');
	
	$('input[name="pps_open_in"]').click(function() {
		checkActiveBox_pps('input#pps_open_in3', '.cpmb_id_pps_exclude_pages');
	});
	
	// OCULTA/MUESTRA CAMPO "OPEN IN URL'S"
	checkActiveBox_pps('input#pps_open_in4', '.cpmb_id_pps_open_in_url');
	
	$('input[name="pps_open_in"]').click(function() {
		checkActiveBox_pps('input#pps_open_in4', '.cpmb_id_pps_open_in_url');
	});
	
	// OCULTA/MUESTRA CAMPO "Lifetime of the Cookie"
	checkActiveBox_pps('input#pps_first_time1', '.cpmb_id_pps_cookie_expire');
	
	$('input[name="pps_first_time"]').click(function() {
		checkActiveBox_pps('input#pps_first_time1', '.cpmb_id_pps_cookie_expire');
		checkActiveBox_pps('input#pps_cookie_expire2', '.cpmb_id_pps_cookie_days');
	});
	
	// OCULTA/MUESTRA CAMPO "Lifetime (days)"
	checkActiveBox_pps('input#pps_cookie_expire2', '.cpmb_id_pps_cookie_days');
	
	$('input[name="pps_cookie_expire"]').click(function() {
		checkActiveBox_pps('input#pps_cookie_expire2', '.cpmb_id_pps_cookie_days');
	});
	
	
	
	//Oculta los Metaboxes
	//$('#side-sortables > div[id*=_cpmb]').addClass('closed');
	
	// Activa ColorPicker en la Página de Opciones
	if(typeof jQuery.fn.wpColorPicker == 'function') {
		$('.pps-colorpicker').wpColorPicker();
	}
	
	// TOOLTIP
	$('p.cpmb_metabox_description sub').hover(
		function(){
			var title = $(this).parent().text();
		
			$(this).data('tipText', title);
			$('<div class="cpmb-tip-wrap"><div class="cpmb-tip-arrow"></div><div class="cpmb-tip-text"></div></div>').appendTo('body');
			$('.cpmb-tip-text').text(title).parent().fadeIn(500);
		},
		function() {
			$('.cpmb-tip-wrap').remove();
		}
	).mousemove(function(w) {
		var widthTip = $('.cpmb-tip-wrap').innerWidth();
        var mousex = w.pageX - widthTip - 15;
        var mousey = w.pageY - 3;
        $('.cpmb-tip-wrap').css({
			top: mousey,
			left: mousex
		});
	});
	
	function checkActiveBox_pps(radioItem, box ){
		if( $(radioItem).is(':checked'))
			$(box).fadeIn();
		else
			$(box).fadeOut();
		
	}
	
});

