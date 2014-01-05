<?php

function advert_display( $atts ) {
  extract( shortcode_atts( array(
//    'size'   => 'medium',
//    'layout' => 0,
    'id'     => 0
  ), $atts ) );

  wp_register_style('askace_advert_styles', plugins_url("askace_adverts/styles.css"));
  wp_enqueue_style('askace_advert_styles');

  global $wpdb;
  $wpdb->askace_adverts_table_name = "{$wpdb->prefix}askace_adverts";

  if ($id==0) { // if a specific add is not requested, then just get a random one:
    $advert = $wpdb->get_row( 'select * from ' . $wpdb->askace_adverts_table_name . ' order by RAND() limit 0,1' );
  } else {
    $advert = $wpdb->get_row( 'select * from ' . $wpdb->askace_adverts_table_name . ' where id = '.$id );
  }

  return getAdWithLayout($advert);
}

function getAdWithLayout($advert) {
  switch ($advert->layouttype) {
    case 15: return getAdCode($advert, 'tab-flat'); break;
    case 14: 
    case 13: 
    case 12: 
    case 11: 
    case 10: 
    case 9: return getAdCode($advert, 'tab-square'); break;
    case 8:
    case 3: return getAdCode($advert, 'tab-tall', true); break;
    case 7: 
    case 6: 
    case 5: 
    case 4: 
    case 2: 
    case 1: 
    default: return getAdCode($advert);
  }
}

/**
* Get the ad code (called when inserted in the post)
* @param $advert Object - DB entry for the advert
* @param $style string - Class for the containing div
* @param $doubleImage bool - Two images or one
*/
function getAdCode($advert, $style = 'tab-tall', $doubleImage = false)
{
  // set a default layout:
  $advert->layouttype = $advert->layouttype ? $advert->layouttype : 1;

  $shortcode = "";
  $shortcode .= "<script>";
  $shortcode .= "jQuery(document).ready(function() {";
  $shortcode .= "  jQuery('.textBig').click(function(e) {";
  //$shortcode .= "    setTimeout('', 3000);";
  $shortcode .= "    jQuery('#ad_heading_".$advert->id."_text').text(e.target.text);";
  $shortcode .= "    jQuery('#ad_heading_".$advert->id."_text').fadeIn('slow');";
  $shortcode .= "    setTimeout('jQuery(\'#ad_heading_".$advert->id."_text\').fadeOut()', 7000);";
  $shortcode .= "  });";
  $shortcode .= "})</script>";
  $shortcode .= "<div id='ad_heading_".$advert->id."_text' class='heading_overlay'>".$advert->heading."</div>";
  $shortcode .= '<div class="'.$style.' askace-advert">';
  $shortcode .= '<form action="https://payment.swipehq.com/" method="POST" enctype="multipart/form-data">
<div style="width:221px; height:36px; border: thin solid grey; background-color: #fff000; text-align: center; border-radius: 9px; cursor: pointer;"><table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr><td><p style="font-family:\'Gill Sans\', \'Tahoma\', sans-serif; font-size: 10px; font-weight: bold; border: none;">Order: <input style="background-color: #facefe; border: 1px solid #000; padding: 2px;" type="text" id="item_quantity" name="item_quantity" size="1" value="1" /></p></td><td align="center" style="border: none;"><input style="cursor:pointer; color:#000; text-decoration: none; font-family:\'Gill Sans\', \'Tahoma\', sans-serif; font-size: 16px; font-weight: bold; border: none; background-color: #fff000;" type="submit" id="submit" value="BUY NOW" name="BUY NOW" /><input type="hidden" id="product_id" name="product_id" value="'.$advert->payment.'"/></td></tr></table></div></td></tr></table></form>';
  $shortcode .= '<ul id="tab'.$advert->layouttype.'"><li><a class="box"></a></li>';
  $shortcode .= '<li><a class="img relink">' . get_image_tag($advert->image,$advert->heading,$advert->heading,'',$size) . "</a></li>";
  if($doubleImage) {
    $shortcode .= '<li><a class="img2 relink">' . get_image_tag($advert->image,$advert->heading,$advert->heading,'',$size) . "</a></li>";
  }
  $shortcode .= '<li><a class="textBig heading" title="Heading: '.$advert->heading.'" id="ad_heading_'.$advert->id.'">'.$advert->heading."</a></li>";
  $shortcode .= '<li><a class="textBig supplier" title="Supplier: '.$advert->supplier.'">'.$advert->supplier."</a></li>";
  $shortcode .= '<li><a class="url" href="http://'.$advert->url.'" title="Website: '.$advert->url.'": target="_blank"><u>'.$advert->url."</u></a></li>";
  $shortcode .= '<li><a class="email" href="mailto:'.$advert->email.'?Subject='.$advert->heading.'" title="Email: '.$advert->email.'" target="_top"><u>'.$advert->email."</u></a></li>";
  $shortcode .= '<li><a class="textBig summary" title="Summary: '.$advert->summary.'">'.$advert->summary."</a></li></ul></div>";

  return $shortcode;
}

add_shortcode( 'askace-adverts', 'advert_display' );
