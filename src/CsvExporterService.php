<?php

namespace Bow\Csv;

use Bow\Database\Barry\Model;
use InvalidArgumentException;
use League\Csv\Reader;
use League\Csv\Writer as LeagueCsvWriter;

class CsvExporterService
{
    /**
     * Export model as csv
     *
     * @param Model $model
     * @param array $headers
     * @return array
     */
    public function model(Model $model, array $headers = ['*'])
    {
        if (!method_exists($model, 'toCsv')) {
            throw new InvalidArgumentException('Model must use \Bow\Csv\CsvExporterTrait::class trait');
        }

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
     * Import csv filename into model
     *
     * @param Model $model
     * @param string $filename
     * @param array $headers
     * @return void
     */
    public function import(Model $model, string $filename, array $headers)
    {
        $csv = Reader::createFromPath($filename)->setHeaderOffset(0);

        // By setting the header offset we index all records
        // With the header record and remove it from the iteration
        foreach ($csv as $record) {
            $data = [];
            foreach ($headers as $header) {
                $data[$header] = $record[$header];
            }

            $model->setAttributes($data);
            $model->save();
        }
    }
}
