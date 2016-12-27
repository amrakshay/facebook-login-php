<?php
/*ADD GIFT TO DESIRED FIELD*/
if($_POST['page'] == 'add_desired')
{
    $updateVal = $_POST['updateVal'];
    $update = array(
        'status' => 'yes'
    );
    //Add the WHERE clauses
    $where_clause = array(
        'couple_name' => $username,
        'gift' => $updateVal
    );
    $updated = $database->update( 'gift_record', $update, $where_clause, 1 );
    if( $updated )
    {
        // echo '<p>Successfully updated '.$where_clause['group_name']. ' to '. $update['group_name'].'</p>';
    }
}
/*REMOVE GIFT FROM DESIRED FIELD*/
if($_POST['page'] == 'cancel_desired')
{
    $updateVal = $_POST['updateVal'];
    $update = array(
        'status' => 'no'
    );
    //Add the WHERE clauses
    $where_clause = array(
        'couple_name' => $username,
        'gift' => $updateVal
    );
    $updated = $database->update( 'gift_record', $update, $where_clause, 1 );
    if( $updated )
    {
        // echo '<p>Successfully updated '.$where_clause['group_name']. ' to '. $update['group_name'].'</p>';
    }
}