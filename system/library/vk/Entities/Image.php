<?php


class VkImage
{
    private $album_id, $date, $id, $owner_id, $has_tags, $sizes, $text, $user_id;
    private $url_s, $url_m, $url_x, $url_y;

    public function __construct($photo)
    {
        $this->album_id = $photo['album_id'];
        $this->date = $photo['date'];
        $this->id = $photo['id'];
        $this->owner_id = $photo['owner_id'];
        $this->has_tags = $photo['has_tags'];
        $this->sizes = $photo['sizes'];
        $this->text = $photo['text'];
        $this->user_id = $photo['user_id'];

        foreach ($photo['sizes'] as $size) {
            switch ($size['type']) {
                case 's':
                    $this->url_s = $photo['sizes'];

                    break;
                case 'm':
                    $this->url_m = $photo['sizes'];

                    break;
                case 'x':
                    $this->url_x = $photo['sizes'];

                    break;
                case 'y':
                    $this->url_y = $photo['sizes'];

                    break;
            }
        }
    }

    public function getAlbumId()
    {
        return $this->album_id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOwnerId()
    {
        return $this->owner_id;
    }

    public function getHasTags()
    {
        return $this->has_tags;
    }

    public function getSizes()
    {
        return $this->sizes;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUrl_s()
    {
        return $this->url_s;
    }

    public function getUrl_m()
    {
        return $this->url_m;
    }

    public function getUrl_x()
    {
        return $this->url_x;
    }

    public function getUrl_y()
    {
        return $this->url_y;
    }
}