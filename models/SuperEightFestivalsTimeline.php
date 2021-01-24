<?php


class SuperEightFestivalsTimeline extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $embed_id = null;

    // ======================================================================================================================== \\=

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`embed_id`         INT UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`embed_id`) REFERENCES {db_prefix}{table_prefix}embeds(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($embed = $this->get_embed()) $embed->delete();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_embed()) $res = array_merge($res, ["embed" => $this->get_embed()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
        $timeline = new SuperEightFestivalsTimeline();
        $embed = SuperEightFestivalsEmbed::create($arr['embed']);
        $timeline->embed_id = $embed->id;
        $timeline->update($arr, false);
        try {
            $timeline->save();
            return $timeline;
        } catch (Exception $e) {
            $embed->delete();
            throw $e;
        }
    }

    public function update($arr, $save = true)
    {
        $cname = get_called_class();
        if (isset($arr['embed'])) {
            $embed = $this->get_embed();
            if (!$embed) throw new Exception("{$cname} is not associated with a SuperEightFestivalsEmbed");
            $embed->update($arr['embed']);
        }

        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @param $search_id
     * @return SuperEightFestivalsTimeline|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsTimeline[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsEmbed|null
     */
    public function get_embed()
    {
        return SuperEightFestivalsEmbed::get_by_id($this->embed_id);
    }

    // ======================================================================================================================== \\
}