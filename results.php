<?php

include('includes/connect.php');
include('includes/config.php');
include('includes/functions.php');

define('PAGE_TITLE', '');

include('includes/header.php');

?>

<h1>Search Results</h1>

<p>This will be your search results page.</p>

<?php


 if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['param'])){
    $search = $_GET['param'];
    $query = "SELECT DISTINCT title, url FROM pages p JOIN page_word pw ON p.id = pw.page_id JOIN words w ON pw.word_id=w.id WHERE w.word LIKE '%$search%'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($display = mysqli_fetch_assoc($result)) {

        echo '<strong>'.($display['title'] ? $display['title'] : 'Missing Title').'</strong>';
        echo '<p><a href="'.$display['url'] .'">'.$display['url'] .'</a></p>';
        // echo '<p>Scrapped at: '.$display['scrapped_at'] .'</p>';
        // echo '<p>Keywords: '.$display['words'] .'</p>';
        echo '<hr>';
        }
    } else {
        echo '<p>No results found for "<strong>' . htmlspecialchars($search) . '</strong>".</p>';
    }

    //SORT OUT AS PER HIGHEST HIT COUNT
}

?>

<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="results.php">Results</a></li>
    <li><a href="dump.php">Dump</a></li>
</ul>

<?php include('includes/footer.php'); ?>