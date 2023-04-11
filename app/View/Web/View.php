<?php

namespace Source\View\Web;

class View extends Resource
{
    use ViewTrait\Home;
    use ViewTrait\BedRoom;
    use ViewTrait\Blog;
    use ViewTrait\Booking;
    use ViewTrait\Contact;
    use ViewTrait\Galery;

    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
