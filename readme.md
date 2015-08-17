# Records (Theme Manager) : Laravel 5.1.x


## Status / Version

Beta Development


## Description
Records extends the ability of the Rakko platform's by providing it with a document, file, image manager.


## Functionality


### Themes
Manage Themes


## Routes

* /admin/themes


## Install

### migration commands

```
php artisan module:migrate Records
php artisan module:seed Records
```


### publish commands

General Publish "ALL" method
```
php artisan vendor:publish --provider="App\Modules\Records\Providers\RecordsServiceProvider"
```

Specific Publish tags
```
php artisan vendor:publish --provider="App\Modules\Records\Providers\RecordsServiceProvider" --tag="configs"
php artisan vendor:publish --provider="App\Modules\Records\Providers\RecordsServiceProvider" --tag="images"
php artisan vendor:publish --provider="App\Modules\Records\Providers\RecordsServiceProvider" --tag="views"
```


## Packages

Intended to be used with:
https://github.com/illuminate3/rakkoII


## Screen Shots
## Thanks
