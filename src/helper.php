<?php

use Bow\Csv\CsvExporterService;
use Bow\Database\Barry\Model;

if (!function_exists('bow_csv_importer')) {
    /**
     * CSV Formatter
     *
     * @param Model $model
     * @param string $filename
     * @param array $headers
     * @return void
     */
    function bow_csv_importer(Model $model, string $filename, array $headers = ['*']): void
    {
        return (new CsvExporterService)->import($model, $filename, $headers);
    }
}

if (!function_exists('bow_csv_exporter')) {
    /**
     * CSV Formatter
     *
     * @param Model $model
     * @param array $headers
     * @return array
     */
    function bow_csv_exporter($model, array $headers = ['*']): array
    {
        return (new CsvExporterService)->model($model, $headers);
    }
}