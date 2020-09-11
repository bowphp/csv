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
    public function importToCsv(string $filename)
    {
       return (new CsvExporterService)->import($this, $filename, $this->csv_headers);
    }
}
