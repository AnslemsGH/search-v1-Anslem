<?php

include('../includes/connect.php');
include('../includes/config.php');
include('../includes/functions.php');

// DELETE FROM pages WHERE id > 1

$query = 'SELECT *
    FROM pages
    -- WHERE id = 302
    ORDER BY linked_at ASC
    LIMIT 1';
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result))
{

    $page = mysqli_fetch_assoc($result);

    echo '<h1>Scanning: '.$page['url'].'</h1>';
    echo '<p><a href="'.$page['url'].'">'.$page['url'].'</a></p>';
    echo '<p>ID: '.$page['id'].'</p>';   
    
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
                            page_id,
                            linked_at,
                            scrapped_at,
                            created_at, 
                            updated_at
                        ) VALUES (
                            "'.$link.'",
                            "'.$page['id'].'",
                            NULL,
                            NULL,
                            NOW(),
                            NOW()
                        )';
                    mysqli_query($connect, $query);

                    echo '<hr>';
                    echo $query;

                }

            }

        }

        
    }

    elseif($status && in_array($status, array(301, 302, 307, 308)))
    {

        $link = get_redirect_url($page['url']);

        if($link)
        {

            $query = 'SELECT *
                FROM pages
                WHERE url = "'.$link.'"
                LIMIT 1';
            $result = mysqli_query($connect, $query);

            if(!mysqli_num_rows($result))
            {

                $query = 'INSERT INTO pages (
                        url, 
                        page_id,
                        linked_at,
                        scrapped_at,
                        created_at, 
                        updated_at
                    ) VALUES (
                        "'.$link.'",
                        "'.$page['id'].'",
                        NULL,
                        NULL,
                        NOW(),
                        NOW()
                    )';
                mysqli_query($connect, $query);

                echo '<hr>';
                echo $query;

            }
        
        }

    }
    
    
}
