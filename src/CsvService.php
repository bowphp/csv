<?php

namespace Bow\Csv;

use Bow\Database\Barry\Model;
use InvalidArgumentException;
use League\Csv\Reader;
use League\Csv\Writer as LeagueCsvWriter;

class CsvService
{
    /**
     * Import csv filename into model
     *
     * @param Model $model
     * @param string $filename
     * @param array $headers
     */
    public function import(Model $model, string $filename, array $headers): void
    {
        $csv = Reader::from($filename)->setHeaderOffset(0);

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

    /**
     * Export csv
     *
     * @param ?string $filename
     * @return string
     */
    public function export(Model $model, ?string $filename = null, array $headers = ['*']): string|int
    {
        $writer = LeagueCsvWriter::fromString('');
    
        if (!method_exists($model, 'toCsv')) {
            throw new InvalidArgumentException('Model must use \Bow\Csv\Csv::class trait');
        }

        $results = $model->select($headers)->get();

        $resolvedHeaders = $headers;

        if ((count($headers) == 1 && $headers[0] == '*') || count($headers) == 0) {
            if ($results->count()) {
                $resolvedHeaders = array_keys($results->first()->toArray());
            }
        }

        // Insert the header
        $writer->insertOne($resolvedHeaders);

        // Insert all the records
        $records = [];
        foreach ($results as $result) {
            $row = $result->toArray();
            $records[] = array_map(fn (string $header) => $row[$header] ?? null, $resolvedHeaders);
        }

        $writer->insertAll($records);

        if (!is_null($filename)) {
            return $writer->download($filename);
        }

        return $writer->toString();
    }
}
