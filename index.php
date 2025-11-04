<?php

include('includes/connect.php');
include('includes/config.php');
include('includes/functions.php');

define('PAGE_TITLE', '');

include('includes/header.php');

?>


<!-- <h1>Search</h1>

<p>This will be your search page.</p> -->

<form action="results.php" method="GET" class="search-bar">
    <input type="text" name="param" placeholder="Search...">
    <input type="submit" name="submit_search" value="Search" class="search-button">
</form>

<!-- <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="results.php">Results</a></li>
    <li><a href="dump.php">Dump</a></li>
</ul> -->



<?php include('includes/footer.php'); ?>