<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>E-Registration</title>
    <style>
        @media screen {
			.header-info{
				font-family: Calibri;
				font-size: 12px;
			}
		}

		@media print {
			.header-info{
				font-family: Calibri;
				font-size: 12px;
				color: #00000;
			}
		}
		
		html{text-align:center}
        body{font-family:Merchant Copy Wide, Merchant Copy Wide; font-size: 12px;color:#000;min-width:960px;max-width:960px;display:inline-block;margin:0 auto 0 0px;}
        .header{width:100%;padding-left:20px;padding-right:20px;}
        .clear{clear:both;}
        .header .logo{float:left;width:100%;text-align:left;padding-top:20px;}
        .header .title{float:left;width:25%;text-align:right;font-size:20pt;padding-top:40px;}
        .header-info{width:100%;padding-top:0px;}
        .header-info .shipping{float:left;width:50%;text-align:left;}
        .header-info .invoice-info{float:left;width:50%;text-align:left;}
        .header-info .invoice-info label{width:500px;}
		.header-info .invoice-info2{float:right;width:50%;text-align:left;}
        .barcode{width:100%;padding-left:20px;padding-right:20px;padding-top:0}
        .order{width:100%;padding-left:20px;padding-right:20px;padding-top:0}
        .order-items{width:100%}
        .order-items table{width:100%;border-left:.5px solid #000;border-top:.5px solid #000;border-spacing:0;border-collapse:collapse;margin-top:5mm}
        .order-items table tr,td{text-align:center;font-size:10px;border-right:.5px solid #000;border-bottom:.5px solid #000;padding:2mm 0}
        .company{width:100%;padding-left:20px;padding-right:20px;padding-top:20px}
    </style>
</head>
<body>    
    <div class="header-info">
		<?php 
			$date_in = date_create($data->date_in);
			$start = date_create($data->product_period_start);
			$end = date_create($data->product_period_end);
			$purchase_date = date_create($data->purchase_date);
			$dokumen = json_decode($data->document_json, true);
			$check = json_decode($data->check_point_json, true);
			
			$contact_number = ($data->contact_number == "" ? "&nbsp;" : $data->contact_number);
			$payment = ($data->has_payment == 1 ? "&#10004;" : "&nbsp;");
			
			// if($data->simpro_category == "new_phone_down"){
				// $simpro_category = "New Phone (1mio - 5mio)";
			// }else if($data->simpro_category == "new_phone_down"){
				// $simpro_category = "New Phone (5mio - 20mio)";
			// }else{
				// $simpro_category = "Used Phone (1mio - 20mio)";
			// }
			
		?>
		<img class="img-responsive" height="1122" width="793" src="<?php echo base_url(); ?>assets/londinium/images/bg-simpro.png" alt="Admin SIMPRO">
		
		<div style="margin-top:-1075px; margin-left:240px;">
			<?= $data->reg_no ?>
			<div style="padding-left:385px; margin-top:-15px;"> <?= $date_in->format("d") ?> </div>
			<div style="padding-left:435px; margin-top:-15px;"> <?= $date_in->format("m") ?> </div>
			<div style="padding-left:485px; margin-top:-15px;"> <?= $date_in->format("Y") ?> </div>
			<div style="margin-top:6px;"> <?= $data->store_name ?> </div>
			
			<div style="margin-top:35px; margin-left:-60px;"> <?= $data->full_name ?> </div>
			<div style="margin-top:15px; margin-left:-60px;"> <?= $data->card_number ?> </div>
			<div style="margin-top:18px; margin-left:-60px;"> <?= $data->address ?> </div>
			<div style="margin-top:20px; margin-left:-60px;"> <?= $data->phone_number ?> </div>
			<div style="margin-top:-15px; margin-left:310px;"> <?= $contact_number ?> </div>
			<div style="margin-top:15px; margin-left:-60px;"> <?= $data->email_address ?> </div>
			<div style="margin-top:15px; margin-left:-60px;"> <?= $data->simpro_category ?> </div>
			
			<div style="margin-top:50px; margin-left:-85px;"> <?= $data->brand ?> </div>
			<div style="margin-top:-18px; margin-left:145px;"> <?= $data->device_type ?> </div>
			<div style="margin-top:20px; margin-left:-85px;"> Rp. <?= number_format($data->sum_insured) ?> </div>
			<div style="margin-top:23px; margin-left:-80px; letter-spacing:17px;"> <?= $data->imei ?> </div>			
			<div style="padding-left:5px; margin-top:25px; margin-left:-80px;"> <?= $start->format("d") ?> </div>
			<div style="margin-top:-15px; margin-left:-30px;"> <?= $start->format("m") ?> </div>
			<div style="margin-top:-15px; margin-left:25px;"> <?= $start->format("Y") ?> </div>
			
			<div style="padding-left:50px; margin-top:-15px; margin-left:55px;"> <?= $end->format("d") ?> </div>
			<div style="margin-top:-15px; margin-left:150px;"> <?= $end->format("m") ?> </div>
			<div style="margin-top:-15px; margin-left:200px;"> <?= $end->format("Y") ?> </div>
			
			<div style="padding-left:5px; margin-top:15px; margin-left:-80px;"> <?= $purchase_date->format("d") ?> </div>
			<div style="margin-top:-15px; margin-left:-30px;"> <?= $purchase_date->format("m") ?> </div>
			<div style="margin-top:-15px; margin-left:25px;"> <?= $purchase_date->format("Y") ?> </div>
			<div style="margin-top:-17px; margin-left:120px;"> <?php  echo $payment; ?> </div>
			<div style="margin-top:10px; margin-left:95px;"> <?= number_format($data->payment_amount) ?> </div>
			
			<?php
				if($dokumen['bukti_pembelian'] == "Y"){
					echo '<div style="margin-top:-140px; padding-left:378px;"> &#10004; </div>';
				}else if($dokumen['bukti_pembelian'] == "N"){
					echo '<div style="margin-top:-140px; padding-left:390px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:-140px; padding-left:378px;"> . </div>';
				}
				
				if($dokumen['kartu_garansi'] == "Y"){
					echo '<div style="margin-top:15px; padding-left:378px;"> &#10004; </div>';
				}else if($dokumen['kartu_garansi'] == "N"){
					echo '<div style="margin-top:15px; padding-left:390px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:15px; padding-left:378px;"> .</div>';
				}
				
				if($dokumen['kartu_identitas'] == "Y"){
					echo '<div style="margin-top:16px; padding-left:378px;"> &#10004; </div>';
				}else if($dokumen['kartu_identitas'] == "N"){
					echo '<div style="margin-top:16px; padding-left:390px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:16px; padding-left:378px;"> . </div>';
				}
				
				if($dokumen['voucher'] == "Y"){
					echo '<div style="margin-top:16px; padding-left:378px;"> &#10004; </div>';
				}else if($dokumen['voucher'] == "N"){
					echo '<div style="margin-top:16px; padding-left:390px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:16px; padding-left:378px;"> . </div>';
				}
				
				
				if($check['unit'] == "Y"){
					echo '<div style="margin-top:-100px; padding-left:485px;"> &#10004; </div>';
				}else if($check['unit'] == "N"){
					echo '<div style="margin-top:-100px; padding-left:500px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:-100px; padding-left:485px;"> . </div>';
				}
				
				if($check['cover'] == "Y"){
					echo '<div style="margin-top:16px; padding-left:485px;"> &#10004; </div>';
				}else if($check['cover'] == "N"){
					echo '<div style="margin-top:16px; padding-left:500px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:16px; padding-left:485px;"> . </div>';
				}
				
				if($check['battery'] == "Y"){
					echo '<div style="margin-top:16px; padding-left:485px;"> &#10004; </div>';
				}else if($check['battery'] == "N"){
					echo '<div style="margin-top:16px; padding-left:500px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:16px; padding-left:485px;"> .</div>';
				}
				
				if($check['other'] == ""){
					echo '<div style="margin-top:14px; font-size:8px; padding-left:480px;"> &nbsp; </div>';
				}else{
					echo '<div style="margin-top:14px; font-size:8px; padding-left:480px;">'.$check['other'].'</div>';
				}
				
				if($data->is_warranty == 1){
					echo '<div style="margin-top:35px; padding-left:378px;"> &#10004; </div>';
				}else if($data->is_warranty == 0){
					echo '<div style="margin-top:35px; padding-left:390px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:35px; padding-left:378px;"> . </div>';
				}
				
				if($data->is_seal == 1){
					echo '<div style="margin-top:-14px; padding-left:485px;"> &#10004; </div>';
				}else if($data->is_seal == 0){
					echo '<div style="margin-top:-14px; padding-left:500px;"> &#10004; </div>';
				}else{
					echo '<div style="margin-top:-14px; padding-left:485px;"> . </div>';
				}


            echo '<div style="font-size:8px; margin-top:534px; padding-left:208px;">'.$data->full_name.'</div>';
            echo '<div style="font-size:8px; margin-top:-10px; padding-left:325px;">'.$data->name.'</div>';
			?>
			
			
		</div>
		
		
    </div>
    
    
    
</body>
</html>