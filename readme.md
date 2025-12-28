# Bowphp CSV

A tiny helper to export and import Eloquent-like models to/from CSV using [league/csv](https://csv.thephpleague.com/).

## Installation

```bash
composer require bowphp/csv
```

## Quick start

1) Add the `Bow\Csv\Csv` trait to your model:

```php
use Bow\Csv\Csv;
use Bow\Database\Barry\Model;

class User extends Model
{
    use Csv;
}
```

2) Export a CSV string (optionally restrict columns):

```php
$user = new User();
$user->setCsvHeaders(['id', 'name']);

$csv = $user->toCsv(); // returns the CSV as a string
```

3) Import rows from a CSV file into your model:

```php
$user = new User();
$user->importCsv('/path/to/file.csv', ['id', 'name', 'email']);
```

Helper functions are also available:

```php
app_export_model_to_csv(new User(), null, ['id', 'name']);
app_import_csv_to_model(new User(), '/path/to/file.csv', ['id', 'name', 'email']);
```

## Contributing

- Fork and create a topic branch.
- Install deps: `composer install`.
- Run tests: `./vendor/bin/phpunit tests --bootstrap=vendor/autoload.php`.
- Submit a PR with a clear description of the change.
