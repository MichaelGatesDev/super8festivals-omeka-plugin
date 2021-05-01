<?php

abstract class S8FDatabaseMigration
{
    abstract function apply();

    abstract function undo();
}