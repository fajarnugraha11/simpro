<!DOCTYPE HTML>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Bigg &raquo; Just another Open Designs template</title>
<meta name="description" content="Just another Open Designs template." />
<meta name="robots" content="noodp,noydir" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" id="child-theme-css" href="<?php echo baseAsset(); ?>notifikasi-theme/css/style.css" type="text/css" media="all" />
<link rel="stylesheet" id="responsive-main-css-css" href="<?php echo baseAsset(); ?>notifikasi-theme/css/responsive-main.min.css" type="text/css" media="all" />
<link rel="stylesheet" id="responsive-css-css" href="<?php echo baseAsset(); ?>notifikasi-theme/css/responsive.css" type="text/css" media="all" />
<link rel="stylesheet" id="tb_styles-css" href="<?php echo baseAsset(); ?>notifikasi-theme/css/tb-styles.min.css" type="text/css" media="all" />

<script type="text/javascript" src="<?php echo baseAsset(); ?>notifikasi-theme/js/jquery.js"></script>

<script type="text/javascript">
  jQuery(window).scroll(function (event) {
	  	
		var top = jQuery('#popular-upcoming').offset().top - jQuery(document).scrollTop();;
		// what the y position of the scroll is
		var y = jQuery(this).scrollTop();
		// whether that's below the form
		if (y >= top)  {
		// if so, add the active class to popular-upcoming and remove from content
		jQuery('.page-nav-popular-posts').addClass('active');
		jQuery('.page-nav-top-posts').removeClass('active');
		} else {
		// otherwise remove it
		jQuery('.page-nav-popular-posts').removeClass('active');
		jQuery('.page-nav-top-posts').addClass('active');
	   }
  });
  
  jQuery(document).ready(function (){
  jQuery('#popular-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#popular-upcoming').offset().top
                     }, 2000);
            //});
        });
		
		jQuery('#feature-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#inner').offset().top
                     }, 2000);
            //});
        });
		  });
	  </script>
</head>

<body class="home blog header-full-width full-width-content">
	<div id="header" style="background: #255086 none repeat scroll 0 0;">
		<div class="site-header">
			<h1 class="site-header-logo-container">
				<a href="https://www.sim.id"><span class="image-replace">SIM</span>
					<img src="<?php echo loadImages()?>/simpro_logo.png" alt="Raja Renov" style="max-width:350%; height:100%;" id="bigg-logo"> 
				</a>
			</h1>

			<ul id="page-nav" class="horizontal-list"> </ul>
			
			<div id="site-header-bigg-social">
				<ul class="horizontal-list">
					<li style="color:white;">For more info : <a href="mailto:info@sim.id" style="color:#50abc2;">info@sim.id</a></li>			
				</ul>
			</div>  
		</div>
	</div>
	
	<div id="wrap">
		<div id="inner">
			<div class="wrap">
				<div id="content-sidebar-wrap">
								
					<div id="content" class="hfeed">
						<div class="post-5 post type-post status-publish format-standard hentry category-featured category-parent-category-i entry feature feature">

							<h2 class="entry-title"><a href="#" title="Welcome to Bigg" rel="bookmark">Selamat proses verifikasi data anda telah berhasil.</a></h2> 

							<div class="entry-content">
							<p>Selanjutnya anda akan dihubungi oleh tim kami untuk .....</p>
							<p>Berikut beberapa artikel pilihan untuk anda.</p>

							</div><!-- end .entry-content -->

						</div><!-- end .postclass -->
						
						<div class="post-1 post type-post status-publish format-standard hentry category-featured category-uncategorized entry fourcol first one-third teaser first">

							<a href="#" title="Hello world!"><img width="300" height="168" src="<?php echo baseAsset(); ?>notifikasi-theme/images/image-1.jpg" class="alignleft post-image" alt="2" /></a>		<h2 class="entry-title"><a href="#" title="Hello world!" rel="bookmark">Hello world!</a></h2> 

							<div class="entry-content">
								<p>Bacon ipsum dolor sit amet kielbasa swine pariatur consequat consectetur esse tongue ea biltong. Fatback dolore ullamco labore in spare ribs ad hamburger cupidatat tongue. Nisi frankfurter duis proident, officia ham aliqua.</p>

								<a class="bigg-read-more" href="http://demo.opendesigns.org/hello-world/">Read Article</a>		
							</div><!-- end .entry-content -->

						</div><!-- end .postclass -->
						
						<div class="post-63 post type-post status-publish format-standard hentry category-child-category-i category-featured category-parent-category-i category-parent-category-ii tag-tag2 tag-tag5 tag-tag6 entry fourcol one-third teaser">

							<a href="#" title="Another Post with Everything"><img width="300" height="168" src="<?php echo baseAsset(); ?>notifikasi-theme/images/image-2.jpg" class="alignleft post-image" alt="3" /></a>		<h2 class="entry-title"><a href="#" title="Another Post with Everything In It" rel="bookmark">Another Post with Everything</a></h2> 

							<div class="entry-content">
								<p>Bacon ipsum dolor sit amet kielbasa swine pariatur consequat consectetur esse tongue ea biltong. Fatback dolore ullamco labore in spare ribs ad hamburger cupidatat tongue. Nisi frankfurter duis proident, officia ham aliqua.</p>

								<a class="bigg-read-more" href="http://demo.opendesigns.org/another-post-with-everything-in-it/">Read Article</a>		
							</div><!-- end .entry-content -->

						</div><!-- end .postclass -->
					
						<div class="post-61 post type-post status-publish format-standard hentry category-featured category-uncategorized entry fourcol one-third teaser">

							<a href="#" title="An Ordered List Post"><img width="300" height="168" src="<?php echo baseAsset(); ?>notifikasi-theme/images/image-3.jpg" class="alignleft post-image" alt="4" /></a>		<h2 class="entry-title"><a href="#" title="An Ordered List Post" rel="bookmark">An Ordered List Post</a></h2> 

							<div class="entry-content">
								<p>Bacon ipsum dolor sit amet kielbasa swine pariatur consequat consectetur esse tongue ea biltong. Fatback dolore ullamco labore in spare ribs ad hamburger cupidatat tongue. Nisi frankfurter duis proident, officia ham aliqua.</p>

								<a class="bigg-read-more" href="http://demo.opendesigns.org/an-ordered-list-post/">Read Article</a>		
							</div><!-- end .entry-content -->

						</div><!-- end .postclass -->
					
					</div><!-- end #content -->

					

					
				</div><!-- end .wrap -->
			</div><!-- end #inner --> 
			
		<div id="bigg-footer">
			<div class="wrap">
			<div class="footer-copyright clear" style="text-align:right;">
			© <span id="footer-copyright-year">2016</span> <a href="https://www.sim.id/">PT Solusi Inti Multiteknik</a>
			</div>
			</div>
		</div>

		</div><!-- end #wrap -->


	</div>
</body>
</html>