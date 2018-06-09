
# Tytuł projektu
Startrek

## Wymagania systemowe
* wersja apache2
* wersja PHP 5.5.9 - 7.1.*
* wersja MySQL Maria DB 10.2
* wersja larevel framework 5.2
* composer
* rozszerzenie PHP OpenSSL  
* rozszerzenie PHP PDO 
* rozszerzenie PHP Mbstring  
* rozszerzenie PHP Tokenizer  


## Instalacja
Wersja uproszczona (jeśli nie brakuje uprawnień)
1) kopiujemy pliki na serwer
2) odpalamy installer.php
3) tworzymy konto admina (normalna procedura rejestracji)
4) odpalamy postinstaller
Kiedy wersja uproszczona nie działa
1) kopiujemy pliki na serwer
2) wykonujemy ręcznie następujące komendy:
php composer install
php composer.phar dumpautoload -o
php artisan config:cache
php artisan route:cache
php artisan migrate
3) odpalamy installer light
4) tworzymy konto admina (normalna procedura rejestracji)
5) odpalamy postinstaller


## Autor

* **Bartosz Kołodziejek** 
* *nr  album: XXXXXX*
* *b_kolo*

## Wykorzystane zewnętrzne biblioteki
 
* jquery 3.3.1
* larevel framework 5.2.45
* bootstrap 4