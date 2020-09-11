<?php

use Bow\Csv\CsvExporterService;
use Bow\Database\Barry\Model;

if (!function_exists('bow_csv_importer')) {
    /**
     * CSV Formatter
     *
     * @param Model $model
     * @param array $headers
     * @return void
     */
    function bow_csv_importer($model, array $headers = ['*'])
    {
        return (new CsvExporterService)->model($model, $headers);
    }
}

if (!function_exists('bow_csv_exporter')) {
    /**
     * CSV Formatter
     *
     * @param Model $model
     * @param array $headers
     * @return void
     */
    function bow_csv_exporter($model, array $headers = ['*'])
    {
        return (new CsvExporterService)->model($model, $headers);
    }
}
