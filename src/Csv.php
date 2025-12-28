<?php

namespace Bow\Csv;

trait Csv
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
    public function toCsv(?string $filename = null): string|int
    {
        return (new CsvService())->export($this, $filename, $this->csv_headers);
    }

    /**
     * Import data from csv
     *
     * @param string $filename
     * @param array $headers
     * @return mixed
     */
    public function importCsv(string $filename)
    {
       return (new CsvService())->import($this, $filename, $this->csv_headers);
    }
}
