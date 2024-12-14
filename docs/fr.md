# Installation

```bash
composer require bowphp/csv
```

## Usage

C'est très simple d'utilisation

```php
use Bow\Csv\CsvExporter;

$user = new App\Models\User;

$csv = CsvExporter::model($user, ['id', 'name', 'description']);

$csv->export();
```
