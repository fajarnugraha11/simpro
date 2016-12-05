<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('isLogin'))
{
    function isLogin()
    {
        $CI =& get_instance();
        $status = $CI->session->userdata('is_login');
        if($status) return TRUE;
        else return FALSE;
    }
}

if(!function_exists('CountTable')) {
    function CountTable($table, $wh, $key)
    {
        $_this = &get_Instance();
        $_this->db->where($wh, $key);
        $query = $_this->db->get($table);
        return $query->num_rows();
    }
}


if(!function_exists('baseEnDec')) {
    function baseEnDec($string, $decrypt = 0)
    {
        if ($decrypt) $text = base64_decode(urldecode($string));
        else $text = urlencode(base64_encode($string));
        return $text;
    }
}

if(!function_exists('slugify')) {
	function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
		return 'n-a';
		}

		return $text;
	}
}