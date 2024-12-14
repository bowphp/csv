<?php

use Bow\Csv\CsvExporter;
use PHPUnit\Framework\TestCase;

class CsvTest extends TestCase
{
    public function test_it_can_get_a_csv()
    {
      $model = new ModelClass(['name' => 'Franck DAKIA', 'username' => 'papac']);

      $this->assertInstanceOf(CsvExporter::class, $model->toCsv());
    }
}