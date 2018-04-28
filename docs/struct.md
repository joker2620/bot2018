Информация
------------

* Документ поддерживается в версиях(ии): 1.1.0;
* [Главная страница][0].

Структура бота
------------

nazbav/
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

* `nazbav/data/` - папка с файлами;
* `nazbav/Configuration/` - папка с настройками бота;
* `nazbav/data/log/` - папка с файлами логов (далее "логи");
* `nazbav/data/base/` - папка с файлами баз данных;
* `nazbav/Source/Commands/` - папка с командами бота;
* `nazbav/Configuration/SustemConfig.php` - настройки системы;
* `nazbav/Configuration/FeaturesConfig.php` - настройки требований;
* `nazbav/Configuration/UserConfig.php` - настройки бота или пользовательские настройки.

[0]: index.md