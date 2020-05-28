<?php

trait S8FMetadata
{
    // ======================================================================================================================== \\

    use S8FRecord;

    public $title = "";
    public $description = "";

    public static function get_db_columns()
    {
        return array(
            "`title`               VARCHAR(255)",
            "`description`         TEXT(65535)",
        );
    }

    public function get_meta_title()
    {
        if ($this->title == null || trim($this->title) == "") return "untitled";
        return $this->title;
    }

    // ======================================================================================================================== \\
}