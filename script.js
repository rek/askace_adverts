jQuery(document).ready(function() {
 jQuery('#upload_image_button').click(function() {
   formfield = jQuery('#upload_image').attr('name');
   tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
   var _TBwindow = jQuery('#TB_window');
   _TBwindow.css('margin-left', '200px');
   _TBwindow.css('margin-top', '300px');
   _TBwindow.css('border', '2px solid #fff');
   _TBwindow.css('height', '290px');
   _TBwindow.css('z-index', '1111');
   _TBwindow.css('background-color', '#000');
   _TBwindow.css('position', 'absolute');
   return false;
 });

 window.send_to_editor = function(html) {
   //var imgurl = jQuery('img',html).attr('src');
   var id = jQuery('class',html);
   jQuery('#upload_image').val(id.match('[0-9].*$'));
   tb_remove();
 }
});