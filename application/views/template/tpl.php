<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title><?php echo $title; ?> - SIMPRO REGISTRATION</title>

    <!-- LOAD CSS -->
<!--	<link rel='shortcut icon' type='image/vnd.microsoft.icon' href="<?php echo imagesAsset()?>favicon.png"/> -->
    <link href="<?php echo loadCss()?>/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo loadCss()?>/londinium-theme.css" rel="stylesheet" type="text/css">
    <link href="<?php echo loadCss()?>/wysihtml5/wysiwyg-color.css" rel="stylesheet" type="text/css">
    <link href="<?php echo loadCss()?>/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo loadCss()?>/icons.css" rel="stylesheet" type="text/css">
	
    <link href="<?php echo loadCss()?>/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
    

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">


    <script type="text/javascript" src="<?php echo backendAsset()?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo backendAsset()?>js/jquery-ui.min.js"></script>




    <!-- LOAD PLUGIN JS -->
    <?php echo $this->load->view('_asset/_js','',true);?>
    <script type="text/javascript" src="<?php echo loadJs()?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/lazzynumeric/jquery.lazzynumeric.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/lazzynumeric/autoNumeric.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/accounting.min.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/application.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/function.js"></script>
    <script type="text/javascript" src="<?php echo loadJs()?>/jquery.form.min.js"></script>


</head>

<body>

<!-- Navbar -->
<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"> 
			<img src="<?php echo loadImages()?>/simpro_logo.png" style="margin-top:-8px; width: 175px; height: 40px; padding:5px;"> 
		</a>
        <a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
            <span class="sr-only">Toggle navbar</span>
            <i class="icon-grid3"></i>
        </button>
        <button type="button" class="navbar-toggle offcanvas">
            <span class="sr-only">Toggle navigation</span>
            <i class="icon-paragraph-justify2"></i>
        </button>
    </div>
    <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
        <li class="user dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">
                <span><?php echo $this->session->userdata('name');?></span>
                <i class="caret"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right icons-right">
                <li><a href="<?php echo site_url('login/dologout');?>"><i class="icon-exit"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</div>
<!-- /navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-content">

            <!-- User dropdown -->
            <div class="user-menu dropdown">
               <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
               <a href=''>
<!--                    <img src="http://placehold.it/300">-->
                    <img class="img-responsive" src="<?php echo loadImages()?>/author.png" alt="<?php echo $this->session->userdata('name');?>" >
                    <div class="user-info">
                        <?php echo $this->session->userdata('fullname') ?> <span><?php echo $this->session->userdata('name');?></span>
                    </div>
                </a>
                <div class="popup dropdown-menu dropdown-menu-right">
                    <div class="thumbnail">
                        <div class="thumb">
                            <!-- <img src="http://placehold.it/300"> -->
                            <div class="thumb-options">
                                        <span>
                                            <a href="#" class="btn btn-icon btn-success"><i class="icon-pencil"></i></a>
                                            <a href="#" class="btn btn-icon btn-success"><i class="icon-remove"></i></a>
                                        </span>
                            </div>
                        </div>

                        <div class="caption text-center">
                            <h6>Madison Gartner <small>Front end developer</small></h6>
                        </div>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item"><i class="icon-pencil3 text-muted"></i> My posts <span class="label label-success">289</span></li>
                        <li class="list-group-item"><i class="icon-people text-muted"></i> Users online <span class="label label-danger">892</span></li>
                        <li class="list-group-item"><i class="icon-stats2 text-muted"></i> Reports <span class="label label-primary">92</span></li>
                        <li class="list-group-item"><i class="icon-stack text-muted"></i> Balance <h5 class="pull-right text-danger">$45.389</h5></li>
                    </ul>
                </div>
            </div>
            <!-- /user dropdown -->


            <!-- Main navigation -->
            <?php echo $this->load->view('template/sidebar_navigation','',true);?>
            <!-- /main navigation -->

        </div>
    </div>
    <!-- /sidebar -->


    <!-- Page content -->
    <div class="page-content">
        <!-- Page header -->
        <div class="page-header">
            <div class="page-title">
                <h3><?php echo $title;?> <small>Welcome <?php echo $this->session->userdata['name']; ?>. 12 hours since last visit</small></h3>
            </div>
            <?php if($this->uri->segment(1) == 'dashboard'){?>
                <!--<div id="reportrange" class="range">
                    <div class="visible-xs header-element-toggle">
                        <a class="btn btn-primary btn-icon"><i class="icon-calendar"></i></a>
                    </div>
                    <div class="date-range"></div>
                    <span class="label label-danger">9</span>
                </div>-->
            <?php } ?>

        </div>
        <!-- /page header -->

        <!-- Breadcrumbs line -->
        <?php if ($this->uri->segment('1') != 'dashboard') {?>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <!-- <li><a href="<?php echo site_url('dashboard')?>">Dashboard</a></li> -->
                <?php
                $segs = $this->uri->segment_array();
                $counter = count($segs);
                $i = 1;
                foreach ($segs as $segment) {
                    $breadline = ucwords(str_replace(array('cms-', '-'), array('', ' '), $segment));
                    $new_breadline = ($breadline == "Merawat" ? "Portofolio" : $breadline);
					$url = $segment.'/';
                    if($i == $counter) {
                        echo "<li >{$new_breadline}</li>";
                    }
                    else {
                        echo "<li><a href='".site_url($url)."'>{$new_breadline}</a> <span class='divider'></span></li>";
                    }
                    $i++;
                }
                ?>
            </ul>

            <div class="visible-xs breadcrumb-toggle">
                <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
            </div>

            <ul class="breadcrumb-buttons collapse">
                <?php if($this->uri->segment('1') == 'dashboard'){?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-search3"></i> <span>Search</span> <b class="caret"></b></a>
                        <div class="popup dropdown-menu dropdown-menu-right">
                            <div class="popup-header">
                                <a href="#" class="pull-left"><i class="icon-paragraph-justify"></i></a>
                                <span>Quick search</span>
                                <a href="#" class="pull-right"><i class="icon-new-tab"></i></a>
                            </div>
                            <form action="#" class="breadcrumb-search">
                                <input type="text" placeholder="Type and hit enter..." name="search" class="form-control autocomplete">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label class="radio">
                                            <input type="radio" name="search-option" class="styled" checked="checked">
                                            Everywhere
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="search-option" class="styled">
                                            Invoices
                                        </label>
                                    </div>

                                    <div class="col-xs-6">
                                        <label class="radio">
                                            <input type="radio" name="search-option" class="styled">
                                            Users
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="search-option" class="styled">
                                            Orders
                                        </label>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-block btn-success" value="Search">
                            </form>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- /breadcrumbs line -->
        <?php } ?>

        <!-- content embed here-->
            <?php echo $this->load->view($content,'',true);?>
        <!-- /content embed here-->

        <div class="clearfix"></div>
        <!-- Footer -->
        <div class="footer clearfix">
            <div class="pull-left">&copy; 2016. SIM</div>

        </div>
        <!-- /footer -->


    </div>
    <!-- /page content -->

</div>
<!-- /page container -->


</body>
</html>



