<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Secure Base URL Helper
 * 
 * Genera URLs seguras que funcionan tanto en HTTP como HTTPS
 */

if ( ! function_exists('secure_base_url'))
{
    function secure_base_url($uri = '')
    {
        $CI =& get_instance();
        $base_url = $CI->config->slash_item('base_url');
        
        // Si ya es HTTPS, usar como está
        if (strpos($base_url, 'https://') === 0) {
            return $base_url . $uri;
        }
        
        // Si es HTTP, convertir a HTTPS
        $secure_url = str_replace('http://', 'https://', $base_url);
        return $secure_url . $uri;
    }
}

if ( ! function_exists('secure_site_url'))
{
    function secure_site_url($uri = '')
    {
        $CI =& get_instance();
        $site_url = $CI->config->site_url($uri);
        
        // Si ya es HTTPS, usar como está
        if (strpos($site_url, 'https://') === 0) {
            return $site_url;
        }
        
        // Si es HTTP, convertir a HTTPS
        return str_replace('http://', 'https://', $site_url);
    }
}

if ( ! function_exists('protocol_relative_url'))
{
    function protocol_relative_url($uri = '')
    {
        $CI =& get_instance();
        $base_url = $CI->config->slash_item('base_url');
        
        // Remover el protocolo para usar URLs relativas al protocolo
        $protocol_relative = preg_replace('/^https?:\/\//', '//', $base_url);
        return $protocol_relative . $uri;
    }
} 