<?php


class _0002_add_video_model extends S8FDatabaseMigration
{
    function apply()
    {
        SuperEightFestivalsVideo::create_table();
    }

    function undo()
    {
        SuperEightFestivalsVideo::drop_table();
    }
}
