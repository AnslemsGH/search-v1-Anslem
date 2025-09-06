<?php

include('includes/connect.php');
include('includes/config.php');
include('includes/functions.php');

define('PAGE_TITLE', '');

include('includes/header.php');

?>

<h1>All Search Records</h1>

<?php 

$query = 'SELECT COUNT(*) AS total FROM pages';
$result = mysqli_query($connect, $query);
$page = mysqli_fetch_assoc($result);
echo '<p>Total Pages: '.$page['total'].'</p>';

$query = 'SELECT COUNT(*) AS total FROM words';
$result = mysqli_query($connect, $query);
$page = mysqli_fetch_assoc($result);
echo '<p>Total Keywords: '.$page['total'].'</p>';

?>

<p>Here is a dump pf alll pages and keywords in the database:</p>

<?php 

$query = 'SELECT *,(
        SELECT GROUP_CONCAT(word SEPARATOR ", ")
        FROM words
        INNER JOIN page_word
        ON word_id = words.id
        WHERE page_word.page_id = pages.id
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