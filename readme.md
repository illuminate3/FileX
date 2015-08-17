# Origami (Theme Manager) : Laravel 5.1.x


## Status / Version

Beta Development


## Description
Origami extends the ability of the Rakko platform's by providing it with a module manager.


## Functionality


### Themes
Manage Themes


## Routes

* /admin/themes


## Install

### migration commands

```
php artisan module:migrate Origmami
php artisan module:seed Origmami
```


### publish commands

General Publish "ALL" method
```
php artisan vendor:publish --provider="App\Modules\Origami\Providers\OrigamiServiceProvider"
```

Specific Publish tags
```
php artisan vendor:publish --provider="App\Modules\Origami\Providers\OrigamiServiceProvider" --tag="configs"
php artisan vendor:publish --provider="App\Modules\Origami\Providers\OrigamiServiceProvider" --tag="images"
php artisan vendor:publish --provider="App\Modules\Origami\Providers\OrigamiServiceProvider" --tag="views"
```


## Packages

Intended to be used with:
https://github.com/illuminate3/rakkoII


## Screen Shots
## Thanks
