<?php

include('includes/connect.php');
include('includes/config.php');
include('includes/functions.php');

define('PAGE_TITLE', '');

include('includes/header.php');

?>

<h1>LEGO&reg; Parts Directory</h1>

<main style="flex-wrap: wrap; gap: 16px; align-items: stretch;">

    <h2 class="w3-green w3-padding">Featured Themes</h2>
    <p>TODO: 4 RANDOM THEMES</p>
    <a href="<?=SITE_URL?>themes.php">View All Themes</a>

    <hr>

    <h2 class="w3-blue w3-padding">Featued Sets</h2>
    <p>TODO: 4 RANDOM COLOURS</p>

    <hr>

    <h2 class="w3-indigo w3-padding">Featued Minifigs</h2>
    <p>TODO: 4 RANDOM MINIFIGS</p>

    <hr>

    <h2 class="w3-purple w3-padding">Featued Parts</h2>
    <p>TODO: 4 RANDOM PARTS</p>

    <hr>

    <h2 class="w3-deep-orange w3-padding">Featured Categories</h2>
    <p>TODO: 4 RANDOM PART CATEGORIES</p>
    <a href="<?=SITE_URL?>categories.php">View All Categories</a>

    <hr>

    <h2 class="w3-dark-grey w3-padding">Featured Colours</h2>
    <p>TODO: 4 RANDOM COLOURS</p>
    <a href="<?=SITE_URL?>colours.php">View All Colours</a>
    
</main>

<?php include('includes/footer.php'); ?>