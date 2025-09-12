<?php

function clean_url($url)
{
    
    $url = trim($url);
    $url = rtrim($url, '/');
    return $url;
    
}

function get_redirect_url($url)
{

    $headers = @get_headers($url, 1);

    if ($headers && isset($headers['Location'])) 
    {
        
        if (is_array($headers['Location'])) 
        {
            return end($headers['Location']);
        }
        
        return $headers['Location'];

    }

    return false;
    
}

function html_fetch_words($html)
{

    $text = strip_tags($html);
    $text = html_entity_decode($text);

    $text = strtolower($text);

    $text = preg_replace('/[^\w\s]/', ' ', $text);

    $words = preg_split('/\s+/', $text);

    $words = array_filter($words, function($word) {
        return strlen($word) >= 3;
    });

    $frequencies = array_count_values($words);

    arsort($frequencies);

    return $frequencies;

}

function html_fetch_title($html)
{

    preg_match('/<title>(.*?)<\/title>/is', $html, $matches);
    return $matches ? $matches[1] : false;

}

function html_fetch_urls($html)
{

    preg_match_all('/<a\s+.*?href=["\'](.*?)["\'].*?>/is', $html, $matches);
    return $matches[1];

}

function url_check_domain($url)
{

    $domains = [
        "brickmmo.com", 
        "codeadam.ca", 
    ];

    foreach ($domains as $domain) 
    {
        if (strpos($url, $domain) !== false) 
        {
            return true;
        }
    }

    return false;

}

function url_content($url)
{

    $content = @file_get_contents($url);
    return $content ? $content : false;

}

function url_status($url)
{

    $headers = @get_headers($url, 1);
    if($headers)
    {
        return substr($headers[0], 9, 3);
    }
    return false;

}

function url_exists($url) 
{

    $headers = @get_headers($url, 1);
    return $headers && strpos($headers[0], '200') !== false;

}

function redirect($page)
{

    header('Location: '.$page);
    die();

}

function select($name, $options, $selected = false)
{
 
    ?>

    <select name="<?=$name?>">

        <?php foreach($options as $value => $option): ?>
            <option value="<?=$value?>"><?=$option?></option>
        <?php endforeach; ?>

    </select>

    <?php

}

function format_date($date, $format = 'date')
{

    if(!is_numeric($date)) $date = strtotime($date);

    switch($format)
    {
        case 'datetime': return '';
        case 'mysql': return date('Y-m-j', $date);
        default: return date('F j, Y', $date);
    }

}

function difference_date($from, $to = false)
{

    if(!$to) $to = time();

    if(!is_numeric($from)) $from = strtotime($from);

    return $from - $to;

}

function leading_zeros($number, $length = 5)
{

    return sprintf('%0'.$length.'d', $number);

}

function number_to_string($number)
{

    $strings = array(
        'zero',
        'one',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine',
        'ten',
        'elevel',
        'twelve'
    );

    return $strings[$number];
}