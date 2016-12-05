<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('hostOrNot'))
{
    function hostOrNot()
    {
        $hostOrNot = FALSE;
        return ($hostOrNot) ? '' : '';
    }
}

if(!function_exists('baseAsset'))
{
    function baseAsset()
    {	
		$url = RELATIVE_PATH_ASSET;
        return $url;
		
        // $path = base_url('assets/');
        // return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('loadCss'))
{
    function loadCss()
    {
        $path = base_url('assets/londinium/css');
        return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('loadImages'))
{
    function loadImages()
    {
        $path = base_url('assets/londinium/images');
        return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('loadJs'))
{
    function loadJs()
    {
        $path = base_url('assets/londinium/js');
        return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('loadPluginJs'))
{
    function loadPluginJs()
    {
        $path = base_url('assets/londinium/js/plugins');
        return ($path != '') ? hostOrNot().$path : false;
    }
}



if(!function_exists('loadMedia'))
{
    function loadMedia()
    {
        $path = base_url('assets/londinium/media');
        return ($path != '') ? hostOrNot().$path : false;
    }
}


// baru

if(!function_exists('desktopAsset'))
{
    function desktopAsset()
    {
        $path = baseAsset().'desktop/';
        return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('mobileAsset'))
{
    function mobileAsset()
    {
        $path = baseAsset().'mobile/';
        return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('backendAsset'))
{
    function backendAsset()
    {
        $path = baseAsset().'backend/';
        return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('emailAsset'))
{
    function emailAsset()
    {
        $path = baseAsset().'email/';
        return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('absPathh'))
{
    function absPathh()
    {
        $path = UPLOAD_URL;
        return $path;
    }
}

if(!function_exists('absPath'))
{
    function absPath()
    {
        $path = UPLOAD;
        return $path;
    }
}

if(!function_exists('absAttachmentInvoice'))
{
    function absAttachmentInvoice()
    {
        $path = absPath().'attachment/';
        return $path;
    }
}

if(!function_exists('imagesAsset'))
{
    function imagesAsset()
    {
        $path = absPathh().'images/';
        return ($path != '') ? hostOrNot().$path : false;
    }
}

if(!function_exists('pluginAsset'))
{
    function pluginAsset()
    {
        $path = baseAsset().'plugin/';
        return ($path != '') ? hostOrNot().$path : false;
    }
}



if(!function_exists('absPathNewsletter'))
{
    function absPathNewsletter($thumbs = false)
    {
        $path = absPath().'images/photo_newsletter/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathPromoPaket'))
{
    function absPathPromoPaket($thumbs = false)
    {
        $path = absPath().'images/photo_promo_paket/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathBerita'))
{
    function absPathBerita($thumbs = false)
    {
        $path = absPath().'images/news/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathEmail'))
{
    function absPathEmail($thumbs = false)
    {
        $path = absPath().'images/email_setting/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathProduct'))
{
    function absPathProduct($thumbs = false)
    {
        $path = absPath().'images/product_icon/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathLogo'))
{
    function absPathLogo($thumbs = false)
    {
        $path = absPath().'images/logo/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathBanner'))
{
    function absPathBanner($thumbs = false)
    {
        $path = absPath().'images/banner/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathProjectUpload'))
{
    function absPathProjectUpload($thumbs = false)
    {
        $path = absPath().'images/project_upload/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathProjectUpdate'))
{
    function absPathProjectUpdate($thumbs = false)
    {
        $path = absPath().'images/project_update/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathPilihanAnda'))
{
    function absPathPilihanAnda($thumbs = false)
    {
        $path = absPath().'images/pilihanAnda/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
} 

if(!function_exists('absPathTestimoni'))
{
    function absPathTestimoni($thumbs = false)
    {
        $path = absPath().'images/testimoni/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathTeam'))
{
    function absPathTeam($thumbs = false)
    {
        $path = absPath().'images/our-team/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathMerawat'))
{
    function absPathMerawat($thumbs = false)
    {
        $path = absPath().'images/merawat/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}

if(!function_exists('absPathFooter'))
{
    function absPathFooter($thumbs = false)
    {
        $path = absPath().'images/footer/';
        if($thumbs) $path .= 'thumbs/';
        return $path;
    }
}
 

if(!function_exists('loadImageNewsletter')) {
    function loadImageNewsletter($file = '', $size = '', $thumbs = false)
    {

    }
}

if(!function_exists('loadImageBerita')) {
    function loadImageBerita($file = '', $size = '', $thumbs = false)
    {

    }
}

if(!function_exists('loadImagePilihanAnda')) {
    function loadImagePilihanAnda($file = '', $size = '', $thumbs = false)
    {

    }
}


