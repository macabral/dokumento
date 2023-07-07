
## Dokumento
php 
Gerenciamento Pessoal de Documentos



# Iniciando o projeto Dokumento
Laravel - Splade - Breeze

laravel new dokumento
 
cd example-app
 
composer require protonemedia/laravel-splade-breeze
 
php artisan breeze:install

composer require spatie/laravel-query-builder

https://github.com/lucascudo/laravel-pt-BR-localization
php artisan lang:publish
composer require lucascudo/laravel-pt-br-localization --dev
php artisan vendor:publish --tag=laravel-pt-br-localization
// Altere Linha 85 do arquivo config/app.php para:
'locale' => 'pt_BR'

php artisan config:clear

in the AppServiceProvider class:

use ProtoneMedia\Splade\Components\Form\Input;
Input::defaultDateFormat('d-m-Y H:i');
Input::defaultTimeFormat('H:i');
Input::defaultDatetimeFormat('d-m-Y H:i');
