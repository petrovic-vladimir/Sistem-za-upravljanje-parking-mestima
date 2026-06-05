<?php
$basePath = strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : '';
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem za upravljanje parking mestima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css">
</head>
<body>
