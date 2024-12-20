<?php

namespace Bow\Csv;

use League\Csv\Writer as LeagueCsvWriter;

class CsvExporter
{
    /**
     * Define the instance of LeagueCsvWriter
     *
     * @var LeagueCsvWriter
     */
    private $writer;

    /**
     * CsvExporter constructor
     *
     * @param LeagueCsvWriter $writer
     * @return void
     */
    public function __construct(LeagueCsvWriter $writer)
    {
        $this->writer = $writer;
    }

    /**
     * Export csv
     *
     * @param string $filename
     * @return string
     */
    public function export(string $filename = null)
    {
        if (!is_null($filename)) {
            return $this->writer->download($filename);
        }

        return $this->writer->toString();
    }
}
