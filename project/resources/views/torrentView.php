<?php
/* @var $torrent \Movies\Entities\Torrent */
$torrent = $data;

if($torrent) {
?>
<div>
    Age: <?php echo $torrent->age;?>
</div>
<div>
    Size: <?php echo $torrent->movieSize;?>
</div>
<div>
    Leach: <?php echo $torrent->leech;?>
</div>
<div>
    Seeds: <?php echo $torrent->seed;?>
</div>
<div>
    Title: <?php echo $torrent->title;?>
</div>
<div>
    Url: <?php echo $torrent->url;?>
</div>
<?php } ?>