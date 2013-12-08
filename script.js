jQuery(document).ready(function() {
 jQuery('#upload_image_button').click(function() {
   formfield = jQuery('#upload_image').attr('name');
   tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
   var _TBwindow = jQuery('#TB_window');
   _TBwindow.css('margin-left', '200px');
   _TBwindow.css('margin-top', '200px');
   _TBwindow.css('border', '1px solid #ccc');
   _TBwindow.css('height', '290px');
   _TBwindow.css('z-index', '1111');
   _TBwindow.css('background-color', '#000');
   _TBwindow.css('position', 'absolute');
   return false;
 });

 window.send_to_editor = function(html) {
   //var imgurl = jQuery('img',html).attr('src');
   var id = jQuery('img',html).attr('class').match('[0-9].*$');
   jQuery('#upload_image').val(id);
   tb_remove();
 }
});