<?php


abstract class Super8FestivalsRecord extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public function create_table()
    {
        create_table(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", $this->get_clazz())),
            $this->get_db_columns(),
            $this->get_table_pk()
        );
    }

    public function create_missing_columns()
    {
        create_missing_columns(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", $this->get_clazz())),
            $this->get_db_columns()
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

    public abstract function get_table_pk();

    public static function get_all()
    {
        return get_db()->getTable(get_called_class())->findAll();
    }

    public static function get_by_id($search_id)
    {
        return get_db()->getTable(get_called_class())->find($search_id);
    }

    public static function get_by_param($param_name, $param_value, $limit = null)
    {
        return get_db()->getTable(get_called_class())->findBy(array($param_name => $param_value), $limit);
    }

    public static function get_by_params($params_arr, $limit = null)
    {
        return get_db()->getTable(get_called_class())->findBy($params_arr, $limit);
    }

}