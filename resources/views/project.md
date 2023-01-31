<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


# Financial Entreprise Api
This API has built to manage transactions of clients 
in a particuler entreprise.
The API has the following features :  

```php
Route::get('/', function () {
    $html = Markdown::parse(File::get('../resources/views/project.md'));
    return view('welcome', [
        'html' => $html
    ]);
});

```