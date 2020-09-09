<?php

namespace Bow\Csv;

use Bow\Database\Barry\Model;
use League\Csv\Writer as LeagueCsvWriter;

class CsvExporterFactory
{
    /**
     * Export model as csv
     *
     * @param Model $model
     * @param array $headers
     * @return array
     */
    public static function model(Model $model, array $headers)
    {
        $collection = $model->select($headers)->get();

        if ((count($headers) == 1 && $headers[0] == '*') || count($headers) == 0) {
            if ($collection->count()) {
                $headers = array_keys($collection->first()->toArray());
            }
        }

        $csv = LeagueCsvWriter::createFromString('');

        // Insert the header
        $csv->insertOne($headers);

        // Insert all the records
        $records = [];
        foreach ($collection as $value) {
            $records[] = array_values($value->toArray());
        }

        $csv->insertAll($records);

        return new CsvExporter($csv);
    }

    /**
     * Build Csv
     *
     * @param array $headers
     * @param array $records
     */
    public function build(array $headers, array $records)
    {
        $csv->insertOne($headers);

        // We create the CSV into memory
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        $csv->insertAll($records);
    }
}
