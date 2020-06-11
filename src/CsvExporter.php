<?php

namespace Bow\Csv;

use Bow\Database\Barry\Model;

class CsvExporter
{
    /**
     * Export model as csv
     *
     * @param Model $model
     * @param array $headers
     * @return array
     */
    public static function model(Model $model)
    {
        if (!method_exists($model, 'exportToCvs')) {
            throw new \InvalidArgumentException('Model must use \Bow\Csv\CsvExporterTrait::class trait');
        }

        return $model->exportToCvs();
    }
}
