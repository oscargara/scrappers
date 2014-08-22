<?php
/**
 * Created by PhpStorm.
 * User: oscargaravito
 * Date: 2014-08-16
 * Time: 11:30 PM
 */

namespace Movies\Entities;


class MovieMeta {
    public $title;
    public $id;
    public $criticMeter;
    public $audienceMeter;
    public $url;
    public $imageUrl;
    public $description;
    /**
     * @var [Torrent]
     */
    public $torrents;
} 