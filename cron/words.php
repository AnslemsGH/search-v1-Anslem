<?php

include('../includes/connect.php');
include('../includes/config.php');
include('../includes/functions.php');

$query = 'SELECT *
    FROM pages
    ORDER BY scrapped_at ASC
    LIMIT 1';
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result))
{

    $page = mysqli_fetch_assoc($result);

    echo '<h1>Scanning: '.$page['url'].'</h1>';
    
    $status = url_status($page['url']);

    echo '<h2>Error Code: ',$status.'</h2>';

    $query = 'DELETE FROM page_word
        WHERE page_id = "'.$page['id'].'"';
    mysqli_query($connect, $query);

    $query = 'UPDATE pages SET
        status = "'.$status.'",
        updated_at = NOW(),
        scrapped_at = NOW()
        WHERE id = '.$page['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    if($status && $status == '200')
    {

        $html = url_content($page['url']);
        $title = html_fetch_title($html);
        $words = html_fetch_words($html);

        $query = 'UPDATE pages SET
            title = "'.$title.'"
            WHERE id = '.$page['id'].'
            LIMIT 1';
        mysqli_query($connect, $query);

        echo '<h2>Words:</h2>';

        foreach($words as $word => $count)
        {

            $word = mysqli_real_escape_string($connect, $word);

            $query = 'SELECT *
                FROM words
                WHERE word = "'.$word.'"
                LIMIT 1';
            $result = mysqli_query($connect, $query);

            if(!mysqli_num_rows($result))
            {

                $query = 'INSERT INTO words (
                        word
                    ) VALUES (
                        "'.$word.'"
                    )';
                mysqli_query($connect, $query);

                $query = 'SELECT *
                    FROM words
                    WHERE word = "'.$word.'"
                    LIMIT 1';
                $result = mysqli_query($connect, $query);

            }

            $word = mysqli_fetch_assoc($result);

            $query = 'INSERT INTO page_word (
                    word_id,
                    page_id,
                    count
                ) VALUES (
                    "'.$word['id'].'",
                    "'.$page['id'].'",
                    "'.$count.'"
                )';
            mysqli_query($connect, $query);

            echo '<hr>';
            echo $query;

        }
        
    }
    
}
