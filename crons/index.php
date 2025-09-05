<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Links</title>
</head>
<body>

    <h1>Import Links</h1>

    <?php
    $files = scandir(__DIR__);
    foreach ($files as $file) 
    {
        if ($file === 'index.php' || $file[0] === '.' || is_dir($file)) 
        {
            continue;
        }
        echo '<a href="' . htmlspecialchars($file) . '">' . htmlspecialchars($file) . '</a><br>';
    }
    ?>
    
</body>
</html>