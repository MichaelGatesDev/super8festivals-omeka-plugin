<?php

//echo json_encode($fields);

echo $this->partial('__components/editable-table.php', array(
    'headers' => $this->tableHeaders,
    'rows' => array_map(function ($record) use ($fields) {
        $result = array();
        foreach ($fields as $field):
            if ($field == false) continue;
            array_push($result, $record->$field);
        endforeach;
        return $result;
    }, $this->records),
));