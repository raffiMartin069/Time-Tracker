<?php
final class SQLoader
{
    function loadSqlQuery($filename) {
        $path = __DIR__ . "/../SQL/" . $filename;
        if (file_exists($path)) {
            return file_get_contents($path);
        } else {
            throw new Exception("Query file does not exist: " . $filename);
        }
    }
}
