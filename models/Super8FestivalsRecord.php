<?php


abstract class Super8FestivalsRecord extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public function create_table()
    {
        create_table(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", $this->get_clazz())),
            $this->get_db_columns(),
            $this->get_db_pk()
        );
    }

    public function drop_table()
    {
        drop_table(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", $this->get_clazz()))
        );
    }

    public abstract function get_clazz();

    public abstract function get_db_columns();

    public abstract function get_db_pk();
}