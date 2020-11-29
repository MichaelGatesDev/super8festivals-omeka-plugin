<?php


abstract class Super8FestivalsRecord extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    public int $created_by_id = 0;
    public string $created_at = "";

    public int $last_modified_by_id = 0;
    public string $modified_at = "";

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
            $user = current_user();
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
                $this->created_by_id = $user->id;
                $this->modified_at = date('Y-m-d H:i:s');
                $this->last_modified_by_id = $user->id;
                logger_log(LogLevel::Debug, "{$user->name} began creating new {$cname}...");
            } else {
                $this->modified_at = date('Y-m-d H:i:s');
                $this->last_modified_by_id = $user->id;
                logger_log(LogLevel::Debug, "{$user->name} began updating {$cname} (ID: {$this->id})...");
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
            $user = current_user();
            if ($insert) {
                logger_log(LogLevel::Info, "{$user->name} successfully created new {$cname} (ID: {$this->id})");
            } else {
                logger_log(LogLevel::Info, "{$user->name} successfully updated {$cname} (ID: {$this->id})");
            }
        }
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        $user = current_user();
        $cname = get_called_class();
        logger_log(LogLevel::Debug, "{$user->name} began deleting {$cname} (ID: {$this->id})...");
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $user = current_user();
        $cname = get_called_class();
        logger_log(LogLevel::Info, "{$user->name} successfully deleted {$cname}");
    }

    public function to_array()
    {
        return array_merge(
            parent::toArray(),
            ["created_by" => filter_array($this->get_created_by(), ["password", "salt"])],
            ["last_modified_by" => filter_array($this->get_last_modified_by(), ["password", "salt"])],
        );
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

    public function get_db_columns()
    {
        return array(
            "`id`                           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            "`created_by_id`                INT(10) UNSIGNED NOT NULL",
            "`created_at`                   VARCHAR(255) NOT NULL",
            "`last_modified_by_id`          INT(10) UNSIGNED NOT NULL",
            "`modified_at`                  VARCHAR(255) NOT NULL",
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

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

    public function get_created_by()
    {
        return get_db()->getTable("User")->find($this->created_by_id);
    }

    public function get_last_modified_by()
    {
        return get_db()->getTable("User")->find($this->last_modified_by_id);
    }

    public function upload_file($formInputName)
    {
        $file = new SuperEightFestivalsFile();

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

    public static abstract function create($arr);

    public function update($arr, $save = true)
    {
        foreach ($arr as $key => $value) {
            $this[$key] = $value;
        }
        if ($save) $this->save(true);
    }

    // ======================================================================================================================== \\
}