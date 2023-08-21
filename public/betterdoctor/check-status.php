    <?php
    require('../../../wp-blog-header.php');
?>
<?php
    $orders = wc_get_orders( array('numberposts' => -1 , 'status' =>'wc-on-hold') );
    $transaction_id = [];

    foreach($orders as $order){
        $id =$order->get_transaction_id();
        array_push($transaction_id , $id);
    }

    $data = array_chunk($transaction_id , 10);  
    foreach ($data as $d){
        $remoteData=ACHP_Main_Class::curlStatusPost($d);
        foreach($remoteData as $row)
        {
            foreach($orders as $order)
            {
                if($order->transaction_id == $row['paymentRefID'])
                {
                    if(!empty($row['status']['Message'])){
                        if($row['status']['Message']=='Pending'){
                        $order->update_status('wc-pending');  
                        } elseif ($row['status']['Message']=='At SB') {
                            $order->update_status('wc-pending');  
                        } elseif($row['status']['Message']=='SB Remit') {
                            $order->update_status('wc-processing');  
                        }elseif($row['status']['Message']=='Returned') {
                            $order->update_status('wc-failed');  
                        }elseif($row['status']['Message']=='Hold') {
                            $order->update_status('wc-on-hold');  
                        }elseif($row['status']['Message']=='Deleted') {
                            $order->update_status('wc-cancelled');  
                        }
                        else {
                            $order->update_status('wc-on-hold');  
                        }
                    } else {
                        $order->update_status('wc-on-hold');    
                }
            } 
        }
    }
}
die(var_dump('success'));