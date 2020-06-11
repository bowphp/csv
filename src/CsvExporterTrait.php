<?php

namespace Bow\Csv;

use Bow\Csv\CsvExporter;
use League\Csv\Writer;

trait CsvExporterTrait
{
    /**
     * Define the CSV headers
     *
     * @var array
     */
    protected $cvs_headers = ["*"];

    /**
     * Export Csv
     *
     * @return array
     */
    public function exportToCsv()
    {
        $collection = $this->select($this->cvs_headers)->get();

        $headers = $this->cvs_headers;

        if ((count($headers) == 1 && $headers[0] == '*') || count($headers) == 0) {
            if ($collection->count()) {
                $headers = array_keys($collection->first()->toArray());
            }
        }
        
        $csv = Writer::createFromString('');

        // Insert the header
        $csv->insertOne($headers);

        // Insert all the records
        $records = [];
        foreach ($collection as $value) {
            $records[] = array_values($value->toArray());
        }

        $csv->insertAll($records);
    }

    /**
     * Import data from csv
     *
     * @param string $filename
     * @param array $headers
     * @return mixed
     */
    public function importCsv($filename, array $headers)
    {
        $csv = Reader::createFromPath($filename)->setHeaderOffset(0);

        // By setting the header offset we index all records
        // With the header record and remove it from the iteration
        foreach ($csv as $record) {
            $data = [];
            foreach ($headers as $header) {
                $data[$header] = $record[$header];
            }

            $this->setAttributes($data);
            $this->save();
        }
    }
}
