<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * cgs publishing system
 *
 * @package		helpers
 * @subpackage	Helpers
 * @category	Helpers
 * @author      Fire
 * @link
 */


// ------------------------------------------------------------------------


/**
 * h_convertUrlQuery
 *
 * url 参数转换成数组
 *
 * @access	public
 * @param	string
 * @return	array
 */

if ( ! function_exists('h_convertUrlQuery'))
{
    function h_convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);

        $params = array();

        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = @$item[1];
        }
        
        return $params;
    }
}

/**
 * h_convertParam
 *
 * q 参数转换成数组
 *
 * @access  public
 * @param   string
 * @return  array
 */

if ( ! function_exists('h_convertParam'))
{
    function h_convertParam($q)
    {
        $queryParts = explode('+', $q);

        $params = array();
        foreach ($queryParts as $id=>$param) {
            if ($id == 0) {
                $params['q'] = $param;
            } else {
                $item = explode(':', $param);
                $params[$item[0]] = @$item[1];
            }
        }
        
        return $params;
    }
}

/**
 * h_convert_param
 *
 * q 参数转换成数组
 *
 * @access  public
 * @param   string
 * @return  array
 */

if ( ! function_exists('h_convert_param'))
{
    function h_convert_param($q)
    {
        $queryParts = explode('+', $q);

        $params = array();
        foreach ($queryParts as $id=>$param) {
            if ($id == 0) {
                $params['q'] = $param;
            } else {
                $key = strstr($param, ':', true);
                if ($key) {
                    $val = substr(strstr($param, ':'), 1);
                    $params[$key] = $val;
                }
            }
        }
        return $params;
    }
}

/**
 * h_create_img_url
 *
 * q 生成图片url地址
 *
 * @access public
 * @param array $carinfo 车辆信息数组
 * @param bool  $wm_open 是否加水印
 * @return string
 */

if ( ! function_exists('h_create_img_url'))
{
    function h_create_img_url($carinfo, $wm_open=FALSE)
    {   
        $CI = & get_instance();
        $CI->load->helper('url');
        
        if ($wm_open) {
            return base_url() . 'index.php/watermark/wm_img?id=' . $carinfo['ID'];
        } else {
            return 'http://10.47.187.166/$carinfo[QMTP]/$carinfo[TJTP]';
        }
    }
}