<?php
global $wpdb;
 
$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 5;
$offset = ( $pagenum - 1 ) * $limit;
$entries = $wpdb->get_results( "SELECT * FROM ".$wpdb->askace_adverts_table_name." LIMIT $offset, $limit" );
 
echo '<div class="wrap">';
 
?>

<h1>View All Adverts</h1>

<table class="widefat">
    <thead>
        <tr>
            <th scope="col" class="manage-column column-name" style="">Id</th>
            <th scope="col" class="manage-column column-name" style="">Heading</th>
            <th scope="col" class="manage-column column-name" style="">Url</th>
            <th scope="col" class="manage-column column-name" style="">Supplier</th>
            <th scope="col" class="manage-column column-name" style="">Date</th>
        </tr>
    </thead>
 
    <tfoot>
        <tr>
            <th scope="col" class="manage-column column-name" style="">Id</th>
            <th scope="col" class="manage-column column-name" style="">Heading</th>
            <th scope="col" class="manage-column column-name" style="">Url</th>
            <th scope="col" class="manage-column column-name" style="">Supplier</th>
            <th scope="col" class="manage-column column-name" style="">Date</th>
        </tr>
    </tfoot>

    <tbody>
        <?php if( $entries ) { ?>
 
            <?php
            $count = 1;
            $class = '';
            foreach( $entries as $entry ) {
                $class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
            ?>
<?php
$page   = 'askace_adverts/adverts-edit.php';
$id     = $entry->id;
$advert_url = add_query_arg(compact('page', 'id'), admin_url('admin.php'));
?>
            <tr<?php echo $class; ?>>
                <td><?php echo $entry->id; ?></td>
                <td><a href="<?php echo $advert_url; ?>"><?php echo $entry->heading; ?></a></td>
                <td><?php echo $entry->url; ?></td>
                <td><?php echo $entry->supplier; ?></td>
                <td><?php echo $entry->created_at; ?></td>
            </tr>
 
            <?php
                $count++;
            }
            ?>
 
        <?php } else { ?>
        <tr>
            <td colspan="2">No Adverts yet</td>
        </tr>
        <?php } ?>
    </tbody>
</table>
 
<?
 
$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM {$wpdb->prefix}askace_adverts" );
$num_of_pages = ceil( $total / $limit );
$page_links = paginate_links( array(
    'base' => add_query_arg( 'pagenum', '%#%' ),
    'format' => '',
    'prev_text' => __( '&laquo;', 'aag' ),
    'next_text' => __( '&raquo;', 'aag' ),
    'total' => $num_of_pages,
    'current' => $pagenum
) );
 
if ( $page_links ) {
    echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
}
 
echo '</div>';