<?php

class SuperEightFestivalsFilmmakerFilm extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $filmmaker_id = null;
    public ?int $video_id = null;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`filmmaker_id`     INT UNSIGNED NOT NULL",
                "`video_id`         INT UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`filmmaker_id`) REFERENCES {db_prefix}{table_prefix}filmmakers(`id`) ON DELETE CASCADE",
                "FOREIGN KEY (`video_id`) REFERENCES {db_prefix}{table_prefix}videos(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($video = $this->get_video()) $video->delete();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_filmmaker()) $res = array_merge($res, ["filmmaker" => $this->get_filmmaker()->to_array()]);
        if ($this->get_video()) $res = array_merge($res, ["video" => $this->get_video()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
        $film = new SuperEightFestivalsFilmmakerFilm();
        $video = SuperEightFestivalsVideo::create($arr['video']);
        $film->video_id = $video->id;
        $film->update($arr, false);
        try {
            $film->save();
            return $film;
        } catch (Exception $e) {
            $video->delete();
            throw $e;
        }
    }

    public function update($arr, $save = true)
    {
        $cname = get_called_class();
        if (isset($arr['video'])) {
            $video = $this->get_video();
            if (!$video) throw new Exception("{$cname} is not associated with a SuperEightFestivalsVideo");
            $video->update($arr['video']);
        }

        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @param $search_id
     * @return SuperEightFestivalsFilmmakerFilm|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsFilmmakerFilm[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsFilmmaker|null
     */
    public function get_filmmaker()
    {
        return SuperEightFestivalsFilmmaker::get_by_id($this->filmmaker_id);
    }

    /**
     * @return SuperEightFestivalsVideo|null
     */
    public function get_video()
    {
        return SuperEightFestivalsVideo::get_by_id($this->video_id);
    }

    // ======================================================================================================================== \\
}