<?php

interface LogLevel
{
    const Error = 0;
    const Warning = 1;
    const Info = 2;
    const Debug = 3;
}

function logger_log($level, $msg)
{
    $timestamp = "[" . date('Y-m-d H:i:s') . "]";

    $levelStr = "";
    switch ($level) {
        case 0:
            $levelStr = "[ERROR]";
            break;
        case 1:
            $levelStr = "[WARNING]";
            break;
        case 2:
            $levelStr = "[INFO]";
            break;
        case 3:
            $levelStr = "[DEBUG]";
            break;
    }

    $log_path = get_logs_dir() . "/" . date("YmdG");

    $current = file_get_contents($log_path);
    $current .= "$timestamp$levelStr: $msg\n";
    file_put_contents($log_path, $current);
}
