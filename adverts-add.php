<style>
  form label{ display: block; }
  .error{ color: red; margin-top: 10px; }
  .preview{ float:right; margin: 100px 25% 0 0; }
  .wrap.askace_add{ float:left; }
  #preview{ cursor: pointer; color: #21759b; text-decoration: underline; }
</style>

<?php $edit = isset($_GET['id']); // check mode, add or edit ?>

<div class="wrap askace_add">
  <?php if ($edit) {
    echo '<h2>Edit Advert ' . $_GET['id'] . '</h2>';
  } else {
    echo '<h2>Add New Advert</h2>';
  } ?>

<?php
  wp_enqueue_script('jquery'); // include jQuery
  wp_register_script('askace_adverts', plugins_url("askace_adverts/script.js"), array('jquery','media-upload','thickbox'));
  wp_enqueue_script('askace_adverts'); // include script.js
  // include the styles here too, so that we can do a sweet preview
  wp_register_style('askace_advert_styles', plugins_url("askace_adverts/styles.css"));
  wp_enqueue_style('askace_advert_styles');

  $ok = false;

  if(isset($_POST['submit'])) {
    global $wpdb;

    // form validation
    $validated = true;
    if (
      trim($_POST['heading']) == '' ||
      trim($_POST['url']) == '' ||
      trim($_POST['supplier']) == ''
    ) { $validated = false; }

    if ($validated) {

      $_POST['url'] = str_replace('http://','',$_POST['url']);

      if ($edit) { // updating
        $wpdb->update( $wpdb->askace_adverts_table_name, array(
          'heading'    => $_POST['heading'],
          'summary'    => $_POST['summary'],
          'url'        => $_POST['url'],
          'supplier'   => $_POST['supplier'],
          'email'      => $_POST['email'],
          'payment'    => $_POST['payment'],
          'image'      => $_POST['upload_image'],
          'layouttype' => $_POST['layouttype'],
        ), array( 'ID' => $_POST['id'] ), array( '%s', '%s', '%s', '%s', '%s', '%s', '%s' ), array( '%d'     ) );

        echo '<div class="updated"><p>Advert Updated</p></div>';
      } else { // adding
        $wpdb->insert( $wpdb->askace_adverts_table_name, array(
          'heading'    => $_POST['heading'],
          'summary'    => $_POST['summary'],
          'url'        => $_POST['url'],
          'supplier'   => $_POST['supplier'],
          'email'      => $_POST['email'],
          'payment'    => $_POST['payment'],
          'layouttype' => $_POST['layouttype'],
          'image'      => $_POST['upload_image'],
          'created_at' => current_time('mysql')
        ) );

        $_GET['id'] = $results['id'] = $wpdb->insert_id;
        echo '<div class="updated"><p>Advert Added: '.$wpdb->insert_id.'</p></div>';
        $edit = true;
       
      }
    } else { // validation error on update or add
      echo '<div class="updated"><p><em class="error">There seems to be an error in the form. Please check all fields again.</em></p></div>';
    }

    $results = $_POST;
    $results['image'] = $_POST['upload_image'];

    $ok = true;

  } else { // loading the ad for editing:

    if(isset($_GET['id'])) { // if we are editing
      $results = $wpdb->get_row( 'select * from ' . $wpdb->askace_adverts_table_name . ' where id = ' . $_GET['id'], ARRAY_A );
      if(sizeof($results)>0) {
        $ok = true;
      }
    }
  }
?>

<form action="" method="post" id="advert_form">
  <div>
    <p>
      <label>
        <big>*Heading:</big>
      </label>
      <input name="heading" value="<?php echo $results['heading']; ?>" size="30">
      <input name="id" value="<?php if($edit) echo $results['id']; ?>" type="hidden">
    </p>
    <p>
      <label><strong>Product Summary:</strong>
      </label>
      <textarea name="summary" rows="5" cols="50"><?php echo $results['summary']; ?></textarea>
    </p>
    <p>
      <label style="color:blue">*<u>Website Link:</u>
      </label>
      <input name="url" value="<?php echo $results['url']; ?>" size="30">
    </p>
    <p>
      <label>*<i>Name of Supplier:</i>
      </label>
      <input name="supplier" value="<?php echo $results['supplier']; ?>" size="30">
    </p>
    <p>
      <label style="color:#ff2200"><u>Email:</u>
      </label>
      <input name="email" value="<?php echo $results['email']; ?>" size="30">
    </p>
    <p>
      <label>Payment:</label>
      <input name="payment" value="<?php echo $results['payment']; ?>" size="30">
    </p>
    <p>
      <label>Layout Type: (1-15)</label>
      <input name="layouttype" value="<?php echo $results['layouttype']; ?>" size="30">
    </p>
    <p>
      <label>Image Id:</label>
      <input id="upload_image" type="text" size="30" name="upload_image" value="<?php echo $results['image']; ?>" />
      <input id="upload_image_button" type="button" value="Select Image" />
    </p>
  </div>
  <div>
    <input type="submit" name="submit" value="<?php echo $edit ? 'Update' : 'Add'; ?>" />
    <?php if ($edit) {
        $delete_url = add_query_arg(array('page'=>'askace_adverts/adverts-admin.php', 'id'=>$results['id'], 'delete'=>'true'), admin_url('admin.php'));
        echo '<a onclick="return confirm(\'Are you sure you want to delete this advert?\')" href="'.$delete_url.'">Delete</a>';
      }
      $page     = 'askace_adverts/adverts-admin.php';
      $view_url = add_query_arg(compact('page'), admin_url('admin.php'));
    ?>
    <span id="preview">Preview</span>
    <a href="<?php echo $view_url; ?>">View All</a>
  </div>
</form>

<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("#preview").click(function(e){
      var data = {
	action: 'preview_advert',
	form: {
          heading: jQuery('input[name=heading]').val(),
          summary: jQuery('textarea[name=summary]').val(),
          url: jQuery('input[name=url]').val(),
          supplier: jQuery('input[name=supplier]').val(),
          email: jQuery('input[name=email]').val(),
          payment: jQuery('input[name=payment]').val(),
          upload_image: jQuery('input[name=upload_image]').val(),
          layouttype: jQuery('input[name=layouttype]').val()
        }
      };
      jQuery.post(ajaxurl, data, function(response) {
	jQuery('.preview').html(response);
      });

    });
  });
</script>

</div>
<div class="preview"></div>