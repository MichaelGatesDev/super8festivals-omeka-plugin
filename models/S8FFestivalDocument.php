<?php

trait S8FFestivalDocument
{
    // ======================================================================================================================== \\

    use S8FDocument;
    use S8FContributable;

    public $festival_id = 0;

    // ======================================================================================================================== \\

    public function get_festival()
    {
        return get_festival_by_id($this->festival_id);
    }

    public function get_city()
    {
        return $this->get_festival()->get_city();
    }

    public function get_country()
    {
        return $this->get_festival()->get_country();
    }

    // ======================================================================================================================== \\
}