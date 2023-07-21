
## Dokumento - Gerenciamento Pessoal de Documentos

Com o Dokumento! você pode armazenar seus documentos pessoais como certidão de nascimento, certidão de casamento, contratos, notas fiscais, extratos, etc. Os documentos são armazenados em formato ZIP e você pode proteger seu documento com uma senha adicional.

Ache seu documento de forma fácil e descomplicada. Você pode fazer o download do documento a qualquer tempo.


# Versões:

v0.1:  21/07/23
- Ordenação do resultado da procura por "created_at" (desc)

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
