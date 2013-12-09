<?php

function advert_display( $atts ) {
  extract( shortcode_atts( array(
    'size'   => 'medium',
    'layout' => rand(1,6)
  ), $atts ) );

  global $wpdb;
  $advert = $wpdb->get_row( 'select * from ' . $wpdb->askace_adverts_table_name . ' order by RAND() limit 1' );

  $shortcode = "";

  switch ($layout) {

    case 1: $shortcode .= 'Layout 1';
      $shortcode .= "<p>".$advert->url."</p>";
      $shortcode .= "<p>".$advert->supplier."</p>";
      $shortcode .= '<form action="https://payment.swipehq.com/" method="POST" enctype="multipart/form-data">
<div style="width:180px; height:30px; border: thin solid grey; background-color: #fff000; text-align: center; border-radius: 9px; cursor: pointer;"><table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr><td><p style="font-family:\'Gill Sans\', \'Tahoma\', sans-serif; font-size: 10px; font-weight: bold; border: none;">Order: <input style="background-color: #FFFFFF; border: 1px solid #CCCCCC; padding: 3px;" type="text" id="item_quantity" name="item_quantity" size="1" value="1" /></p></td><td align="center" style="border: none;"><input style="cursor:pointer; color:#000; text-decoration: none; font-family:\'Gill Sans\', \'Tahoma\', sans-serif; font-size: 16px; font-weight: bold; border: none; background-color: #fff000;" type="submit" id="submit" value="BUY NOW" name="BUY NOW" /><input type="hidden" id="product_id" name="product_id" value="'.$advert->payment.'" /></td></tr></table></div></td></tr></table></form>';
      $shortcode .= "<p>".$advert->heading."</p>";
      $shortcode .= "<a href=''>" . get_image_tag(2822,'alt','title','',$size) . "</a>";
    break;

    case 2: $shortcode .= 'Layout 2';
      $shortcode .= "<p>".$advert->url."</p>";
      $shortcode .= "<p>".$advert->supplier."</p>";
      $shortcode .= '<form action="https://payment.swipehq.com/" method="POST" enctype="multipart/form-data">
<div style="width:180px; height:30px; border: thin solid grey; background-color: #fff000; text-align: center; border-radius: 9px; cursor: pointer;"><table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr><td><p style="font-family:\'Gill Sans\', \'Tahoma\', sans-serif; font-size: 10px; font-weight: bold; border: none;">Order: <input style="background-color: #FFFFFF; border: 1px solid #CCCCCC; padding: 3px;" type="text" id="item_quantity" name="item_quantity" size="1" value="1" /></p></td><td align="center" style="border: none;"><input style="cursor:pointer; color:#000; text-decoration: none; font-family:\'Gill Sans\', \'Tahoma\', sans-serif; font-size: 16px; font-weight: bold; border: none; background-color: #fff000;" type="submit" id="submit" value="BUY NOW" name="BUY NOW" /><input type="hidden" id="product_id" name="product_id" value="'.$advert->payment.'" /></td></tr></table></div></td></tr></table></form>';
      $shortcode .= "<p>".$advert->heading."</p>";
      $shortcode .= "<a href=''>" . get_image_tag(2822,'alt','title','',$size) . "</a>";
    break;

    case 3: $shortcode .= 'Layout 3';
    break;

    default: 
      $shortcode .= "<a href=''>" . get_image_tag(2822,'alt','title','',$size) . "</a>";
      $shortcode .= '<form action="https://payment.swipehq.com/" method="POST" enctype="multipart/form-data">
<div style="width:180px; height:30px; border: thin solid grey; background-color: #fff000; text-align: center; border-radius: 9px; cursor: pointer;"><table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr><td><p style="font-family:\'Gill Sans\', \'Tahoma\', sans-serif; font-size: 10px; font-weight: bold; border: none;">Order: <input style="background-color: #FFFFFF; border: 1px solid #CCCCCC; padding: 3px;" type="text" id="item_quantity" name="item_quantity" size="1" value="1" /></p></td><td align="center" style="border: none;"><input style="cursor:pointer; color:#000; text-decoration: none; font-family:\'Gill Sans\', \'Tahoma\', sans-serif; font-size: 16px; font-weight: bold; border: none; background-color: #fff000;" type="submit" id="submit" value="BUY NOW" name="BUY NOW" /><input type="hidden" id="product_id" name="product_id" value="'.$advert->payment.'" /></td></tr></table></div></td></tr></table></form>';
    $shortcode .= "<p>".$advert->url."</p>";
    $shortcode .= "<p>".$advert->supplier."</p>";
  break;

  }



  return $shortcode;
}

add_shortcode( 'askace-adverts', 'advert_display' );