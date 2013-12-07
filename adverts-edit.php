<style>
  .addForm label{ display: block; }
  .error{ color: red; margin-top: 10px; }
</style>

<h1>Edit Advert <?php echo $_GET['id']; ?></h1>

<?php
$ok = false;

if(isset($_POST['submit'])) {
  global $wpdb;

  if(trim($_POST['heading']) != '' ||
     trim($_POST['url']) != '' ||
     trim($_POST['supplier']) != ''){

$wpdb->update( $wpdb->askace_adverts_table_name, array( 
      'heading'    => $_POST['heading'], 
      'summary'    => $_POST['summary'],
      'url'        => $_POST['url'],
      'supplier'   => $_POST['supplier'],
      'email'      => $_POST['email'],
      'payment'    => $_POST['payment'],
      'layouttype' => $_POST['layouttype'],
), array( 'ID' => $_POST['id'] ), array( '%s', '%s', '%s', '%s', '%s', '%d', '%s' ), array( '%d' ) );

    echo '<div class="updated"><p>Advert Updated</p></div>';

  } else {
    echo '<div class="updated"><p><em class="error">There seems to be an error in the form. Please check all fields again.</em></p></div>';

  }

  $ok = true;
}

if(isset($_GET['id'])) {

  $results = $wpdb->get_results( 'select * from ' . $wpdb->askace_adverts_table_name . ' where id = ' . $_GET['id'] );
  if(sizeof($results)>0) {
    $ok = true;
    $results = $results[0];
  }
}



if($ok){ ?>

<form class="addForm" name="addForm" action="" method="post">
<div>
  <p>
    <label>
      <big>*Heading:</big>
    </label>
    <input name="heading" value="<?php echo $results->heading; ?>" size="30">
    <input name="id" value="<?php echo $results->id; ?>" type="hidden">
  </p>
  <p>
    <label><strong>Product Summary:</strong>
    </label>
    <textarea name="summary" rows="5" cols="50"><?php echo $results->summary; ?></textarea>
  </p>
  <p>
    <label style="color:blue">*<u>Website Link:</u>
    </label>
    <input name="url" value="<?php echo $results->url; ?>" size="30">
  </p>
  <p>
    <label>*<i>Name of Supplier:</i>
    </label>
    <input name="supplier" value="<?php echo $results->supplier; ?>" size="30">
  </p>
  <p>
    <label style="color:#ff2200"><u>Email:</u>
    </label>
    <input name="email" value="<?php echo $results->email; ?>" size="30">
  </p>
  <p>
    <label>Payment:</label>
    <input name="payment" value="<?php echo $results->payment; ?>" size="30">
  </p>
  <p>
    <label>Layout Type:</label>
    <input name="layouttype" value="<?php echo $results->layouttype; ?>" size="30">
  </p>
</div>
<div>
  <input type="submit" name="submit" value="Update" />
<?php
$page     = 'askace_adverts/adverts-admin.php';
$id       = $results->id;
$delete_url = add_query_arg(compact('page', 'id'), admin_url('admin.php'));
?>
  <a onclick="return confirm('Are you sure you want to delete this advert?')" href="<?php echo $delete_url; ?>">Delete</a>
<?php
$page     = 'askace_adverts/adverts-admin.php';
$view_url = add_query_arg(compact('page'), admin_url('admin.php'));
?>
  <a href="<?php echo $view_url; ?>">View All</a>
</div>
</form>

<?php } else { ?>
    <div class="updated"><p><em class="error">There has been an error, we cannot find the advert you are looking for.</em></p></div>
<?php } ?>