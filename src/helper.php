<?php

use Bow\Csv\CsvService;
use Bow\Database\Barry\Model;

if (!function_exists('app_import_csv_to_model')) {
    /**
     * CSV Formatter
     *
     * @param Model $model
     * @param string $filename
     * @param array $headers
     * @return void
     */
    function app_import_csv_to_model(Model $model, string $filename, array $headers = ['*'])
    {
        (new CsvService())->import($model, $filename, $headers);
    }
}

if (!function_exists('app_export_model_to_csv')) {
    /**
     * CSV Formatter
     *
     * @param Model $model
     * @param array $headers
     * @return array
     */
    function app_export_model_to_csv($model, ?string $filename,array $headers = ['*']): string|int
    {
        return (new CsvService())->export($model, $filename, $headers);
    }
}