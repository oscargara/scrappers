<ul class="dvds">
    <?php
    foreach ($data['dvds'] as $dvd) {
        echo $this->renderZone('movieView', $dvd);
    }
    ?>
</ul>