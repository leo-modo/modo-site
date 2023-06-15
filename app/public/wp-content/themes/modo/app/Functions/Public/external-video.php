<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 *
 */
class Modo_External_Video {

    /**
     * url
     *
     * @var mixed
     */
    private $url;

    /**
     * type
     *
     * @var mixed
     */
    private $type;

    /**
     * id
     *
     * @var mixed
     */
    private $id;

    /**
     * thumbnail
     *
     * @var mixed
     */
    private $thumbnail = false;

    /**
     * frame
     *
     * @var mixed
     */
    private $frame = false;

    /**
     * __construct
     *
     * @param  mixed $video_url
     * @return void
     */
    public function __construct($video_url) {
        $this->url = $video_url;
    }


	/**
	 * @return array
	 */
	public function get() : array {

        // get type
        $this->get_type();

        // get id
        $this->get_id();

        // get thumbnail
        $this->get_thumbnail();

        // Get frame //
        $this->get_frame();

        return [
            'thumbnail' => $this->thumbnail,
            'frame' => $this->frame
        ];
    }

    /**
     * get_type
     *
     * @return void
     */
    public function get_type() {

        if (strpos($this->url, 'youtube.com')) {
            $this->type = 'youtube.com';
        }

        if (strpos($this->url, 'youtu.be')) {
            $this->type = 'youtu.be';
        }
    }

    /**
     * get_id
     *
     * @return void
     */
    public function get_id() {

        switch ($this->type) {

            case 'youtube.com':

                $explode = explode('v=', $this->url);
                $this->id = $explode[1];

                break;

            case 'youtu.be':

                $explode = explode('/', $this->url);
                $this->id = end($explode);

                break;
        }
    }

    /**
     * get_thumbnail
     *
     * @return void
     */
    public function get_thumbnail() {

        switch ($this->type) {

            case 'youtube.com':
            case 'youtu.be':
                $this->thumbnail = 'https://img.youtube.com/vi/' . $this->id . '/hqdefault.jpg';
                break;
        }
    }

    /**
     * get_frame
     *
     * @return void
     */
    public function get_frame() {

        switch ($this->type) {

            case 'youtube.com':
            case 'youtu.be':
                $this->frame = '<iframe width="1280" height="720" src="https://www.youtube.com/embed/' . $this->id . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                break;
        }
    }
}
