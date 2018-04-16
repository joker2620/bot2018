Информация
------------

* Документ поддерживается в версиях(ии): 0.2.1-alpha2;
* [Главная страница][0].

Структура бота
------------

joker2620/
* Configuration/
  * *Features*Config.php
  * *Sustem*Config.php
  * *User*Config.php
* Source/
  * *Commands*/
     * ...
  * ...
  * Core.php
* data/
  * audio/
  * base/
    * base.bin
    * UserMessages.json
  * images/
  * log/
    * ErrorLog/
    * chats/
    
Описание файлов и папок
------------

* `joker2620/data/` - папка с файлами;
* `joker2620/Configuration/` - папка с настройками бота;
* `joker2620/data/log/` - папка с файлами логов (далее "логи");
* `joker2620/data/base/` - папка с файлами баз данных;
* `joker2620/Source/Commands/` - папка с командами бота;
* `joker2620/Configuration/SustemConfig.php` - настройки системы;
* `joker2620/Configuration/FeaturesConfig.php` - настройки требований;
* `joker2620/Configuration/UserConfig.php` - настройки бота или пользовательские настройки.

[0]: index.md