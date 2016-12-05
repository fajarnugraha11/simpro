<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TAA</title>

    <link href="<?php echo loadFrontendCss()?>/bootstrap.css" rel="stylesheet">
    <link href="<?php echo loadFrontendCss()?>/main.css" rel="stylesheet">
    <link href="<?php echo loadFrontendCss()?>/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo loadFrontendCss()?>/animate-custom.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    <script src="<?php echo loadFrontendJs()?>/jquery.min.js"></script>
    <script src="<?php echo loadFrontendJs()?>/modernizr.custom.js" type="text/javascript"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
</head>

<body data-spy="scroll" data-offset="0" data-target="#navbar-main">
<div id="navbar-main">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <img id="img-logo" src="<?php echo loadFrontEndImg()?>/logo-taa.png"></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right" style="font-size: 14px">
                    <li class="active"><a href="#home" class="smoothScroll">Home</a></li>
                    <li> <a href="#about" class="smoothScroll"> About</a></li>
                    <li> <a href="#services" class="smoothScroll"> Our Services</a></li>
                    <li> <a href="#portfolio" class="smoothScroll"> Our Program</a></li>
                    <li> <a href="#contact" class="smoothScroll"> Upcoming Project</a></li>
                    <li> <a href="#footerwrap" class="smoothScroll">Our Partner</a></li>
                    <li> <a data-toggle="modal" href="#myModal">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ==== HOME ==== -->
<div id="headerwrap" name="home"></div>

<!-- ==== ABOUT ==== -->
<div id="about" name="about">
    <div class="container">
        <div class="row white">
            <h2 class="centered">ABOUT US</h2>
            <div class="col-md-12">
                <p class="centered">Lorem ipsum dolor sit amet, quo meis audire placerat eu, te eos porro veniam. An everti maiorum detracto mea. Eu eos dicam voluptaria, erant bonorum albucius et per, ei sapientem accommodare est. Saepe dolorum constituam ei vel. Te sit malorum ceteros repudiandae, ne tritani adipisci vis.</p>
                <p class="centered">Lorem ipsum dolor sit amet, quo meis audire placerat eu, te eos porro veniam. An everti maiorum detracto mea. Eu eos dicam voluptaria, erant bonorum albucius et per, ei sapientem accommodare est. Saepe dolorum constituam ei vel. Te sit malorum ceteros repudiandae, ne tritani adipisci vis.</p>
            </div>
            <div class="col-md-6 centered">
                <h2>MISSION</h2>
                <p>Lorem ipsum dolor sit amet, quo meis audire placerat eu, te eos porro veniam. An everti maiorum detracto mea. Eu eos dicam voluptaria, erant bonorum albucius et per, ei sapientem accommodare est. Saepe dolorum constituam ei vel.</p>
            </div>
            <div class="col-md-6 centered">
                <h2>VISION</h2>
                <p>Lorem ipsum dolor sit amet, quo meis audire placerat eu, te eos porro veniam. An everti maiorum detracto mea. Eu eos dicam voluptaria, erant bonorum albucius et per, ei sapientem accommodare est. Saepe dolorum constituam ei vel.</p>
            </div>

            <div class="col-md-12"> <img class="img-responsive" src="<?php echo loadFrontEndImg()?>/about_img.png" align=""> </div>
        </div>
    </div>
</div>

<!-- ==== SERVICES ==== -->
<div id="services" name="services">
    <div>
        <div class="top-left" >
            <div>
                <img src="<?php echo loadFrontEndImg()?>/icon/img_panda_orange.png" align="">
            </div>
        </div>
        <div class="top-right">
            <div class="title">
                <h2 class="centered">OUR SERVICES</h2>
                <div class="col-lg-12 centered ">
                    <p>
                        Proses pembelajaran yang kami sediakan diantaranya, pelatihan guru, buku cetak, sumber pengajaran, media pembelajaran yang secara keseluruhan menggunakan pola Panda Mandarin.
                    </p>
                </div>
            </div>
            <div class="menu-icon">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div><img src="<?php echo loadFrontEndImg()?>/icon/icon-panda-learning.png"></div>
                    <div><a><h6>PANDA E-LEARNING</h6></a></div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div><img src="<?php echo loadFrontEndImg()?>/icon/panda-shop.png"></div>
                    <div><a><h6>PANDA SHOP</h6></a></div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div><img src="<?php echo loadFrontEndImg()?>/icon/panda-corporate.png"></div>
                    <div><a><h6>CORPORATE TRAINING</h6></a></div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div><img src="<?php echo loadFrontEndImg()?>/icon/panda-hsk-center.png"></div>
                    <div><a><h6>HSK CENTER</h6></a></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="bottom-left">
        <div>
            <h2 class="centered">WHY PEOPLE SHOULD <br> LEARN MANDARIN</h2>
            <div class="col-lg-12 centered ">
                <p class="small">
                    Bahasa Mandarin merupakan bahasa yang paling banyak digunakan orang di seluruh dunia setelah bahasa Inggris.
                    Saat ini jumlah penduduk di china di perkirakan hampir mencapai milyaran juta jiwa. Dan semuanya diwajibkan bertutur bahasa resmi nasional yaitu Bahasa Mandarin.
                </p>
                <p class="small">
                    Manfaat belajar bahasa Mandarin sangat banyak. Belajar bahasa Mandarin selain membantu kita dalam berkomunikasi juga akan meningkatkan kepercayaan diri kita dalam kehidupan sehari-hari.
                    Anda yang seorang pengusaha akan lebih mudah menjalin hubungan bisnis, jika anda mampu menguasai bahasa Mandarin.
                    Karena kesuksesan menjalin hubungan bisnis biasa diawali dari sebuah komunikasi yang lancar. Bahasa Mandarin tidak hanya berguna dalam hal bisnis, tetapi banyak hal lainnya juga.
                </p>
            </div>
        </div>

    </div>
    <div class="bottom-right">
        <div>
            <img src="<?php echo loadFrontEndImg()?>/icon/img_random_2.png" align="">
        </div>
    </div>
    <div class="clearfix"></div>
</div>


<!-- ==== PROGRAM ==== -->
<div id="portfolio" name="portfolio">
    <div class="container">
        <div class="">
            <div class="col-md-8 col-md-offset-2 centered" style="background-color: #ffffff">
                <h2 class="centered" style="background-color: #ffffff">OUR PROGRAM</h2>
                <p>
                    Salah satu keunggulan dari perusahaan kami adalah tersedianya kerjasamay yang baik dengan lembaga pendidikan yang resmi dan teraktreditasi di China,
                    dengan adanya kerjasama tersebut maka akan memudahkan anda untuk memilih dan memutuskan kemana anda akan pergi, di universitas mana anda akan belajar, serta dimana anda akan tinggal.

                </p>
                <p>
                    Salah satu keunggulan dari perusahaan kami adalah tersedianya kerjasamay yang baik dengan lembaga pendidikan yang resmi dan teraktreditasi di China,
                    dengan adanya kerjasama tersebut maka akan memudahkan anda untuk memilih dan memutuskan kemana anda akan pergi, di universitas mana anda akan belajar, serta dimana anda akan tinggal.

                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="mt_10">
            <div class="col-md-2"></div>
            <div class="col-md-8 centered">
                <div id="side-left">
                    <div class="box-img">
                        <img style="width: 100%" class="ximg-responsive" src="<?php echo loadFrontEndImg()?>/our-program.jpg" alt="">
                        <!--<div style="background-color: #ffffff;">SUMMER/WINTER CAMP</div>-->
                    </div>
                </div>
                <div id="side-right">
                    <div class="box-img">
                        <img style="width: 100%" class="ximg-responsive" src="<?php echo loadFrontEndImg()?>/our-program.jpg" alt="">
                        <!--<div style="background-color: #ffffff">SUMMER/WINTER CAMP</div>-->
                    </div>
                </div>

            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="col-xs-12 col-md-12 col-sm-12 centered">
            <a data-toggle="modal" href="#myModal">
                <button class="btn btn btn-sm" type="submit">CONTACT US</button>
            </a>
        </div>
    </div>
</div>

<!-- ==== UPCOMING PROJECT ==== -->
<div id="contact" name="contact">
    <div class="col-md-8 col-md-offset-2 centered">
        <div class="side-left">
            <div class="box-img">
                <img style="margin-left: auto;margin-right: auto" class="img-responsive" src="<?php echo loadFrontEndImg()?>/img_random_3.png" alt="">
            </div>
        </div>
        <div class="side-right">
            <div class="title">
                <div class="title">
                    <h2 class="centered">UPCOMING PROJECT</h2>
                    <div class="centered ">
                        <p>
                            Proses pembelajaran yang kami sediakan diantaranya, pelatihan guru, buku cetak, sumber pengajaran, media pembelajaran yang secara keseluruhan menggunakan pola Panda Mandarin.
                        </p>
                    </div>
                    <div class="box-img" style="padding: 5px">
                        <img style="margin-left: auto;margin-right: auto" class="img-responsive" src="<?php echo loadFrontEndImg()?>/logo.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="clearfix"></div>

<!--OUR PARTNER-->
<div id="footerwrap">
    <div class="container">
        <div class="row">
            <h2 class="centered">OUR PARTNER</h2>
            <div class="col-lg-12">
                <img class="img-responsive" src="<?php echo loadFrontEndImg()?>/our-partner.png" alt="">
            </div>
            <br>
            <div class="col-xs-12 col-md-12 col-sm-12 centered">
                <button class="btn btn btn-sm" type="submit">FRANCHISE OPPORTINTY</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL FORM-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div id="modalform-contact" class="modal-content">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 centered">
                    <h2>CONTACT US</h2>
                    <p class="small">If you have any question, feel free fill this form and click on the submit</p>
                    <form  method="post" action='<?php echo site_url('home/contact');?>' class="form" role="form">
                        <div class="row">
                            <div class="col-xs-6 col-md-6 form-group">
                                <input class="form-control" id="name" name="name" placeholder="Name" type="text" required />
                            </div>
                            <div class="col-xs-6 col-md-6 form-group">
                                <input class="form-control" id="email" name="email" placeholder="Email" type="email" required />
                            </div>
                        </div>
                        <textarea class="form-control" id="message" name="message" placeholder="Message" rows="5"></textarea>
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <button class="btn btn btn-lg" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                    <div style="padding-bottom: 20px">
                        <img class="img-responsive" src="<?php echo loadFrontEndImg()?>/img-footer-contact.png">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="<?php echo loadFrontEndJs()?>/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="assets/js/retina.js"></script> -->
<script type="text/javascript" src="<?php echo loadFrontEndJs()?>/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo loadFrontEndJs()?>/smoothscroll.js"></script>
<script type="text/javascript" src="<?php echo loadFrontEndJs()?>/jquery-func.js"></script>
</body>
</html>
