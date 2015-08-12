$(document).ready(function(){
	$('a.window').click(function(){
		window.open(this.href);
		return false;
	});
	$('a[href*=.pdf]').append(' <span class="pdf">(.pdf)</span>');
	$('a[href*=.pdf]').click(function(){
				window.open(this.href);
	return false;
	});
	$("#sidebar .subnav li:first-child").addClass("current");
	$("#content ul.grid-fields li:nth-child(4n)").addClass("fourth");
	$("#content p span").css('font-size', 'x-small').addClass("x-small")
	// opens all pdfs in new tab
 	$("a[href$='.pdf']").attr("target", "_blank");
	$('#nav li').not('#nav li li').append(':');
	$('#content .entry ul li').wrap("<span></span>");
	$('#content .entry ul li').wrapInner("<span></span>");
});