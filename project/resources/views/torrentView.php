<?php
/* @var $torrent \Movies\Entities\Torrent */
$torrent = $data;

if($torrent) {
?>
<div class="torrent-info">
    <h3>Torrent info</h3>
    <div>
        <span class="label">Age:</span> <?php echo $torrent->age;?>
    </div>
    <div>
        <span class="label">Size:</span> <?php echo $torrent->movieSize;?>
    </div>
    <div>
        <span class="label">Leach:</span> <?php echo $torrent->leech;?>
    </div>
    <div>
        <span class="label">Seeds:</span> <?php echo $torrent->seed;?>
    </div>
    <div>
        <span class="label">Title:</span> <?php echo $torrent->title;?>
    </div>
    <div>
        <span class="label">Url:</span> <?php echo $torrent->url;?>
    </div>
</div>
<?php } ?>