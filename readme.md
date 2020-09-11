# Bowphp CSV

CSV formatter for Bowphp

## Installation

```bash
composer require bowphp/csv
```

## Usage

Is very easy to usage.

```php
use Bow\Csv\CsvExporter;

$user = new App\Models\User;

$csv = CsvExporter::model($user, ['id', 'name', 'description']);

$csv->export();
```
