var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;
function jsddm_open()
{
 jsddm_canceltimer();
 jsddm_close();
 ddmenuitem = $(this).find('ul').css('display', 'block');
 $(this).find('a').addClass('active');
}
function jsddm_close()
{
 if(ddmenuitem) ddmenuitem.css('display', 'none');
 $('#jsddm #wp_menufication li a').removeClass('active');
}
function jsddm_timer()
{
 closetimer = window.setTimeout(jsddm_close, timeout);
}
function jsddm_canceltimer()
{
 if(closetimer)
 {
  window.clearTimeout(closetimer);
  closetimer = null;
 }
}
$(document).ready(function()
{
 $('#jsddm #wp_menufication > li').bind('mouseover', jsddm_open)
 $('#jsddm #wp_menufication > li').bind('mouseout',  jsddm_timer)
});
document.onclick = jsddm_close;
