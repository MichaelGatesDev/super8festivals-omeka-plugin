<?php


abstract class Super8FestivalsRecord extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    public function getResourceId()
    {
        return Inflector::tableize(get_called_class());
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $cname = get_called_class();
        if (array_key_exists("record", $args)) {
            $record = $args['record'];
        }
        if (array_key_exists("insert", $args)) {
            $insert = $args['insert'];
            if ($insert) {
                logger_log(LogLevel::Info, "Creating new ${cname}");
            } else {
                logger_log(LogLevel::Info, "Updating ${cname} (ID: {$this->id})");
            }
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $cname = get_called_class();
        if (array_key_exists("record", $args)) {
            $record = $args['record'];
        }
        if (array_key_exists("insert", $args)) {
            $insert = $args['insert'];
            if ($insert) {
                logger_log(LogLevel::Info, "Created new ${cname}");
            } else {
                logger_log(LogLevel::Info, "Updated ${cname} (ID: {$this->id})");
            }
        }
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        $cname = get_called_class();
        logger_log(LogLevel::Info, "Deleting ${cname} (ID: {$this->id})");
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $cname = get_called_class();
        logger_log(LogLevel::Info, "Deleted ${cname}");
    }

    // ======================================================================================================================== \\

    public function create_table()
    {
        create_table(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", get_called_class())),
            $this->get_db_columns(),
            $this->get_table_pk()
        );
    }

    public function create_missing_columns()
    {
        create_missing_columns(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", get_called_class())),
            $this->get_db_columns()
        );
    }

    public function drop_table()
    {
        drop_table(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", get_called_class()))
        );
    }

    public abstract function get_db_columns();

    public abstract function get_table_pk();

    public static function get_all()
    {
        return get_db()->getTable(get_called_class())->findAll();
    }

    public static function get_by_id($search_id)
    {
        $res = get_db()->getTable(get_called_class())->find($search_id);
        if (!($res instanceof Super8FestivalsRecord)) {
            return null;
        }
        return $res;
    }

    public static function get_by_param($param_name, $param_value, $limit = null)
    {
        return get_db()->getTable(get_called_class())->findBy(array($param_name => $param_value), $limit);
    }

    public static function get_by_params($params_arr, $limit = null)
    {
        return get_db()->getTable(get_called_class())->findBy($params_arr, $limit);
    }

    // ======================================================================================================================== \\

    protected function _createRelationship()
    {
        return null;
    }

    public function upload_file($formInputName)
    {
        $file_relationship = $this->_createRelationship();
        if($file_relationship == null) return null;
        if (!$file_relationship->save()) return null;

        $file = new SuperEightFestivalsFile();
        $file->resource_relationship_id = $file_relationship->id;

        list($original_name, $temporary_name, $extension) = get_temporary_file($formInputName);
        $uniqueFileName = uniqid() . "." . $extension;
        move_tempfile_to_dir($temporary_name, $uniqueFileName, get_uploads_dir());
        $file->file_name = $uniqueFileName;
        $file->create_thumbnail();

        $this->file_id = $file->id;
        try {
            $this->save();
            return $file;
        } catch (Omeka_Record_Exception $e) {
            logger_log(LogLevel::Info, $e->getMessage());
        } catch (Omeka_Validate_Exception $e) {
            logger_log(LogLevel::Info, $e->getMessage());
        }
        return null;
    }

    // ======================================================================================================================== \\
}