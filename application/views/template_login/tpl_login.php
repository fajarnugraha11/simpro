<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title><?php echo $title; ?></title>
	<link rel='shortcut icon' type='image/vnd.microsoft.icon' href="<?php echo imagesAsset()?>favicon.png"/>
    <!-- LOAD CSS-->
    <link href="<?php echo loadCss()?>/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo loadCss()?>/londinium-theme.css" rel="stylesheet" type="text/css">
    <link href="<?php echo loadCss()?>/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo loadCss()?>/icons.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	
    <script type="text/javascript" src="<?php echo backendAsset()?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo backendAsset()?>/js/jquery-ui.min.js"></script>
    <!-- LOAD JS -->
    <script type="text/javascript" src="<?php echo backendAsset()?>/js/login.js"></script>
    <?php echo $this->load->view('_asset/_js','',true);?>
	<script type="text/javascript" src="<?php echo loadJs()?>/lazzynumeric/jquery.lazzynumeric.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/lazzynumeric/autoNumeric.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/application.js"></script>
    <!-- <script type="text/javascript" src="<?php //echo loadJs()?>/function.js"></script> -->

</head>

<body class="full-width page-condensed">

<!-- Navbar -->
<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <h1 style="color: #ffff0; padding:10px;">
			 <img src="<?php echo loadImages()?>/simpro_logo.png" alt="Raja Renov" style="width: 250px; height: 50px;"> 
		</h1>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-right">
            <span class="sr-only">Toggle navbar</span>
            <i class="icon-grid3"></i>
        </button>
<!--        <a class="navbar-brand" href="#"><img src="--><?php //echo loadImages()?><!--/logo.png" alt="XX"></a>-->
    </div>
</div>
<!-- /navbar -->

<?php echo $this->load->view($content,'',true); ?>

<!-- Footer -->
<div class="footer clearfix">
    <div class="pull-left">&copy; <?php echo date("Y"); ?>. SIM </a></div>

</div>
<!-- /footer -->


</body>
</html>

