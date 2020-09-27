<?php

class SuperEightFestivalsFestivalMemorabilia extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFestivalDocument;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FFestivalDocument::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->festival_id) || !is_numeric($this->festival_id)) {
            $this->addError('festival_id', 'You must select a valid festival!');
        }
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_memorabilia";
    }

    // ======================================================================================================================== \\
}