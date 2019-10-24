<?php

echo $this->partial('__components/table.php', array(
    'headers' => $this->tableHeaders,
    'rows' => array_map(function ($record) use ($fields) {
        $result = array();
        foreach ($fields as $field):
            array_push($result, $record->$field);
        endforeach;
        return $result;
    }, $this->records),
));