<?php

namespace Bow\Csv;

use League\Csv\Reader as LeagueCsvReader;

trait CsvExporterTrait
{
    /**
     * Define the CSV headers
     *
     * @var array
     */
    protected $csv_headers = ["*"];

    /**
     * Set the CSV headers
     *
     * @param array $headers
     * @return void
     */
    public function setCsvHeaders(array $headers)
    {
        $this->csv_headers = $headers;
    }

    /**
     * Export Csv
     *
     * @return array
     */
    public function toCsv()
    {
        return (new CsvExporterService)->model($this, $this->csv_headers);
    }

    /**
     * Import data from csv
     *
     * @param string $filename
     * @param array $headers
     * @return mixed
     */
    public function importCsv($filename)
    {
        $csv = LeagueCsvReader::createFromPath($filename)->setHeaderOffset(0);

        // By setting the header offset we index all records
        // With the header record and remove it from the iteration
        foreach ($csv as $record) {
            $data = [];
            foreach ($this->csv_headers as $header) {
                $data[$header] = $record[$header];
            }

            $this->setAttributes($data);
            $this->save();
        }
    }
}
