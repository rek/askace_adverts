<?php

if(isset($_POST['submit'])) {
  //require_once('../../../wp-config.php');
  global $wpdb;

  if(trim($_POST['heading']) != '' ||
     trim($_POST['url']) != '' ||
     trim($_POST['supplier']) != ''){

    $wpdb->insert( $wpdb->askace_adverts_table_name, array( 
      'heading'    => $_POST['heading'], 
      'summary'    => $_POST['summary'],
      'url'        => $_POST['url'],
      'supplier'   => $_POST['supplier'],
      'email'      => $_POST['email'],
      'payment'    => $_POST['payment'],
      'layouttype' => $_POST['layouttype'],
      'created_at' => current_time('mysql')
    ) );

    echo '<p class="updated">Advert Inserted</p>';
  } else {
    echo '<em class="error">There seems to be an error in the form. Please check all fields again</em>';

  }

}

?>

<style>
  .addForm label{ display: block; }
  .error{ color: red; margin-top: 10px; }
</style>

<div class="wrap">  
    <?php    echo "<h2>" . 'Add new Advert' . "</h2>"; ?> 
</div>

<form class="addForm" name="addForm" action="" method="post">
<div>
  <p>
    <label>
      <big>*Heading:</big>
    </label>
    <input name="heading" value="" size="30">
  </p>
  <p>
    <label><strong>Product Summary:</strong>
    </label>
    <textarea name="summary" value="" rows="5" cols="50"></textarea>
  </p>
  <p>
    <label style="color:blue">*<u>Website Link:</u>
    </label>
    <input name="url" value="" size="30">
  </p>
  <p>
    <label>*<i>Name of Supplier:</i>
    </label>
    <input name="supplier" value="" size="30">
  </p>
  <p>
    <label style="color:#ff2200"><u>Email:</u>
    </label>
    <input name="email" value="" size="30">
  </p>
  <p>
    <label>Payment:</label>
    <input name="payment" value="" size="30">
  </p>
  <p>
    <label>Layout Type:</label>
    <input name="layouttype" value="" size="30">
  </p>
</div>
<div>
  <input type="submit" name="submit" value="Add" />
<?php
$page     = 'adverts-adverts';
$view_url = add_query_arg(compact('page'), admin_url('admin.php'));
?>
  <a href="<?php echo view_url; ?>">View All</a>
</div>
</form>