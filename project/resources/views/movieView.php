<?php
/* @var $dvd \Movies\Entities\MovieMeta */
$dvd = $data;
?>
<li class="dvd-item">
    <table>
        <tr>
            <td><img class="dvd-image" alt="<?php echo $dvd->title ?>" src="<?php echo $dvd->imageUrl ?>"></img></td>
            <td>
                <h2><a target="_blank" href="<?php echo $dvd->url; ?>"><?php echo $dvd->title; ?></a></h2>
                <div>Critics: <?php echo $dvd->criticMeter; ?>%</div>
                <div>Audience: <?php echo $dvd->audienceMeter; ?>%</div>
                <?php echo $this->renderZone('torrentView', current($dvd->torrents)); ?>
            </td>

        </tr>
    </table>
</li>