<!DOCTYPE html>
<html>
<head>
    <title>Download TV Series</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel=stylesheet href="<?php echo PROJECT_URL;?>/css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.8.1/build/cssreset/cssreset-min.css">
</head>

<body class="main">
<div >
    <?php echo isset($zones['main']) ?  $zones['main']: ''; ?>
</div>
<?php echo isset($zones['main-foot']) ?  $zones['main-foot']: ''; ?>
<?php if (isset($zones['logs'])) echo $zones['logs'] ?>
</body>

</html>