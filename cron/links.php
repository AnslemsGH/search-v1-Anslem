<?php

include('../includes/connect.php');
include('../includes/config.php');
include('../includes/functions.php');

$query = 'SELECT *
    FROM pages
    ORDER BY linked_at ASC
    LIMIT 1';
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result))
{

    $page = mysqli_fetch_assoc($result);

    echo '<h1>Scanning: '.$page['url'].'</h1>';
    
    $status = url_status($page['url']);

    echo '<h2>Error Code: ',$status.'</h2>';

    $query = 'UPDATE pages SET
        status = "'.$status.'",
        updated_at = NOW(),
        linked_at = NOW()
        WHERE id = '.$page['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    if($status && $status == '200')
    {

        $html = url_content($page['url']);
        $links = html_fetch_urls($html);

        echo '<h2>Pages:</h2>';

        foreach($links as $link)
        {

            if(url_check_domain($link))
            {   
            
                $link = mysqli_real_escape_string($connect, $link);
                $link = clean_url($link);

                $query = 'SELECT *
                    FROM pages
                    WHERE url = "'.$link.'"
                    LIMIT 1';
                $result = mysqli_query($connect, $query);

                if(!mysqli_num_rows($result))
                {

                    $query = 'INSERT INTO pages (
                            url, 
                            linked_at,
                            scrapped_at,
                            created_at, 
                            updated_at
                        ) VALUES (
                            "'.$link.'",
                            NULL,
                            NULL,
                            NOW(),
                            NOW()
                        )';
                    mysqli_query($connect, $query);

                }

            }

        }
        
    }
    
}
