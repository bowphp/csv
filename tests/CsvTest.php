<?php

use PHPUnit\Framework\TestCase;
use Tests\Stubs\DommyModelClass;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\Bow\Csv\Csv::class)]
#[CoversClass(\Bow\Csv\CsvService::class)]
class CsvTest extends TestCase
{
    public function test_can_get_a_csv()
    {
        $model = new DommyModelClass();
        $model->setDataset([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'email@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
        ]);

        $csv = $model->toCsv();

        $this->assertIsString($csv);
        $this->assertStringContainsString("id,name,email", (string) $csv);
        $this->assertStringContainsString("John Doe", (string) $csv);
        $this->assertStringContainsString("Jane Smith", (string) $csv);
    }

    public function test_can_get_a_csv_with_custom_headers()
    {
        $model = new DommyModelClass();
        $model->setCsvHeaders(['name']);
        $model->setDataset([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'email@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
        ]);

        $csv = $model->toCsv();

        $this->assertStringStartsWith("name", (string) $csv);
        $this->assertStringContainsString("John Doe", (string) $csv);
        $this->assertStringNotContainsString("email@example.com", (string) $csv);
    }

    public function test_import_csv_persists_rows_on_model()
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'csv_import_');

        file_put_contents($tempFile, implode(PHP_EOL, [
            'id,name,email',
            '1,John Doe,john@example.com',
            '2,Jane Smith,jane@example.com',
        ]));

        $model = new DommyModelClass();
        $model->setCsvHeaders(['id', 'name', 'email']);

        (new \Bow\Csv\CsvService())->import($model, $tempFile, ['id', 'name', 'email']);

        $this->assertCount(2, $model->saved);
        $this->assertSame(
            ['id' => '1', 'name' => 'John Doe', 'email' => 'john@example.com'],
            $model->saved[0]
        );
        $this->assertSame(
            ['id' => '2', 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
            $model->saved[1]
        );

        unlink($tempFile);
    }
}
