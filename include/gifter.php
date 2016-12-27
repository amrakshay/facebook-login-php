<?php

#1 Find Couple Using ID
#2 INFO OF THE COUPLE
#3 GIFTS CHECK OF THE COUPLES
#4 FETCH PRICE OF THE EVENT
#5 GIFT TO COUPLE FROM GIFTER

/*Find Couple Using ID*/
if($_POST['page'] == 'findCouple')
{
    $couplePin = $_POST['searchVal'];
    $query = "SELECT * FROM `couple_users` WHERE couple_pin LIKE '%$couplePin%'";
    $results = $database->get_results( $query );
    foreach( $results as $row )
    {
        $username = $row['user_name'];
        if($username != $_SESSION['user_name']) {

            echo '<div class="hvr-float-shadow col-lg-2 col-sm-2 col-xs-12" onclick="coupleInfo(this.id);" id="' . $username . '" >
                            <div class="card" style="margin-bottom: 4px;background:#7f7f7f;background:rgba(255,255,255,0.5);">
                                <div class="card-body " style="padding: 2px;margin-left:60px;" >
                                     <div class="checkbox checkbox-styled w3-margin-top">
                                           <label><span>' . $username . '</span></label>
                                     </div>
                                </div>
                            </div>
                         </div>';

        }

    }

}

/*INFO OF THE COUPLE*/
if($_POST['page'] == 'coupleInfo')
{
    $updateVal = $_POST['updateVal'];
    $query = "SELECT * FROM `gift_record` WHERE couple_name='$updateVal'";
    $results = $database->get_results( $query );
    foreach( $results as $row )
    {
        if($row['status'] == 'yes')
        {
            $event = $row['gift'];
            echo '<div class="hvr-grow col-lg-4 col-sm-4" onclick="apperModel(this.id,'."'$event'".')" id="'.$updateVal.'">
                        <div class="card" style="margin-bottom: 10px;">
                            <div class="card-body " style="padding: 10px;">
                                 <img src="images/bunjee-jumping.jpg" alt="Avatar" style="width:100%">
                                 <div class="checkbox checkbox-styled w3-margin-top">
                                 <input type="checkbox">
                                       <label><span>'.$row['gift'].'</span></label>
                                 </div>
                            </div>
                        </div>
                     </div>';
        }
    }

}

/*GIFTS CHECK OF THE COUPLES*/
if($_POST['page'] == 'checkGifts')
{
    $updateVal = $_POST['updateVal'];
    $query = "SELECT * FROM `gift_record` WHERE couple_name='$updateVal'";
    $results = $database->get_results( $query );
    foreach( $results as $row )
    {
        if($row['status'] == 'gifted')
        {
            $event = $row['gift'];
            echo '<div class="hvr-grow col-lg-4 col-sm-4" onclick="removeAddons(this.id,'."'$event'".')" id="'.$updateVal.'">
                        <div class="card" style="margin-bottom: 10px;background:#7f7f7f;background:rgba(255,255,255,0.5);">
                            <div class="card-body " style="padding: 10px;">
                                 <img src="images/bunjee-jumping.jpg" alt="Avatar" style="width:100%">
                                 <div class="checkbox checkbox-styled w3-margin-top">
                                       <label><span>'.$event.'</span></label>
                                       <label class="w3-text-teal"><span>Gift From - '.$row['gifter_name'].'</span></label>
                                 </div>
                            </div>
                        </div>
                     </div>';
        }
    }

}

/*FETCH PRICE OF THE EVENT*/
if($_POST['page'] == 'fetchPrice')
{
    $updateVal = $_POST['updateVal'];
    $updateGift = $_POST['updateGift'];
    //echo $updateVal.$updateGift;

    $query = "SELECT * FROM `addons_list` WHERE `addon_name`='$updateGift'";
    $results = $database->get_results( $query );
    foreach( $results as $row )
    {
            echo '<div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="closeModel();">×</button>
                                    <h4 class="modal-title" id="simpleModalLabel">Addon Information</h4>
                                </div>
                                <div class="modal-body">
                                        <div class="form-group">
												<input type="text" class="form-control" id="readonly5" value="'.$updateGift.'" readonly="">
										</div>
										<div class="form-group">
												<input type="text" class="form-control" id="readonly6" value="'.$row['addon_price'].'" readonly="">
										</div>
										<div class="form-group">
										    <h4 class="modal-title" id="simpleModalLabel">Choose Payment Method</h4>
												<div class="col-sm-9" id="payment_type">
													<label class="radio-inline radio-styled radio-primary">
														<input type="radio" name="r1"><span>Paypal</span>
													</label>
													    <input type="hidden" name="business" value="'.$paypal_id.'" id="paypal_id">
													    <input type="hidden" name="url" value="'.$paypal_url.'" id="paypal_url">
													    <!-- Specify a Buy Now button. -->
                                                        <input type="hidden" name="cmd" value="_xclick">
                                                        <!-- Specify details about the item that buyers will purchase. -->
                                                        <input type="hidden" name="currency_code" value="USD">
												</div>
											</div>
                                </div>
                                <div class="modal-footer">
                                <!--<button type="button" onclick="paypalPayment(this.id,'."'$updateGift'".')" class="btn btn-primary" id="'.$updateVal.'">GIFT TO '.$updateVal.' </button>
                                   --><button type="button" onclick="addAddons(this.id,'."'$updateGift'".')" class="btn btn-primary" id="'.$updateVal.'">GIFT TO '.$updateVal.' </button>
                               
                                </div>
                            </div>
                        </div>';
    }
}
/*GIFT TO COUPLE FROM GIFTER*/
if($_POST['page'] == 'giftToCouple')
{
    $updateVal = $_POST['updateVal'];
    $updateGift = $_POST['updateGift'];

    $query = "SELECT * FROM `gift_record` WHERE couple_name='$updateVal' and gift='$updateGift'";
    $results = $database->get_results( $query );
    foreach( $results as $row )
    {
        $update = array(
            'gifter_name' => $username,
            'status' => 'gifted'
        );
        $where_clause = array(
            'couple_name' => $updateVal,
            'gift' => $updateGift
        );
        $updated = $database->update( 'gift_record', $update, $where_clause, 1 );
        if( $updated )
        {
            echo '<p>Successfully updated</p>';
        }
    }
}

/*CANCEL GIFT FROM COUPLE*/
if($_POST['page'] == 'removeGift')
{
    $updateVal = $_POST['updateVal'];
    $updateGift = $_POST['updateGift'];

    $query = "SELECT * FROM `gift_record` WHERE couple_name='$updateVal' and gift='$updateGift'";
    $results = $database->get_results( $query );
    foreach( $results as $row )
    {
        $update = array(
            'gifter_name' => '',
            'status' => 'yes'
        );
        $where_clause = array(
            'couple_name' => $updateVal,
            'gift' => $updateGift
        );
        $updated = $database->update( 'gift_record', $update, $where_clause, 1 );
        if( $updated )
        {
            echo '<p>Successfully updated</p>';
        }
    }

}
