<?php

include('includes/connect.php');
include('includes/config.php');
include('includes/functions.php');

define('PAGE_TITLE', '');

include('includes/header.php');

?>

<h1>All Search Records</h1>

<p>Here is a dump pf alll pages and keywords in the database:</p>

<?php 

$query = 'SELECT *,(
        SELECT GROUP_CONCAT(word SEPARATOR ", ")
        FROM words
        WHERE words.page_id = pages.id
    ) AS words
    FROM pages
    ORDER BY scrapped_at DESC';
$result = mysqli_query($connect, $query);

while($page = mysqli_fetch_assoc($result)) 
{

    echo '<strong>'.($page['title'] ? $page['title'] : 'Missing Title').'</strong>';
    echo '<p><a href="'.$page['url'] .'">'.$page['url'] .'</a></p>';
    echo '<p>Scrapped at: '.$page['scrapped_at'] .'</p>';
    echo '<p>Keywords: '.$page['words'] .'</p>';
    echo '<hr>';

}

?>

<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="results.php">Results</a></li>
    <li><a href="dump.php">Dump</a></li>
</ul>

<?php include('includes/footer.php'); ?>