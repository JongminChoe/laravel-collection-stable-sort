# laravel-collection-stable-sort
Stable sort macro for Laravel Collection

## Installation
This package **DOES NOT** support install as a Composer Dependency.  
You have to install this package mannually.

1. Copy `CollectionStableSortServiceProvider.php` file to your Laravel Application's `app/providers` directory.
2. Register service provider by adding line below in `config/app.php` file's `provider` array.
  `App\Providers\CollectionStableSortServiceProvider::class`
  or check [this](https://laravel.com/docs/6.x/providers#registering-providers) to how to register service provider.

## Requirements
* PHP >= 7.0  
* Laravel >= 5.5

## Usage
### Sort by value (ascending order)
```php
$collection->stableSort();
```

### Sort by single field (ascending order)
```php
$collection->stableSort('field_name');
```
or
```php
$collection->stableSort(['field_name']);
```
or
```php
$collection->stableSort(['field_name' => 'asc']);
```

### Sort by single field (descending order)
```php
$collection->stableSort(['field_name' => 'desc']);
```

### Sort by value compare function
```php
$collection->stableSort(function ($a, $b) { ... });
```

### Sort by multiple fields
sort by 'first' field in ascending order first  
if 'first' field is equal, then sort by 'second' field in descending order  
if 'second' field is also same, then sort by callback function like PHP's usort() function.
```php
$collection->stableSort([
    'first',
    'second' => 'desc',
    function ($a, $b) { ... },
]);
```

## License
```
Copyright 2020 Jongmin Choe

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```
