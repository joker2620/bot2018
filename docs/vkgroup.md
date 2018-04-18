Информация
------------

* Документ поддерживается в версиях(ии): 1.0.0;
* [Главная страница][0];
* Перед выполнением настроек выполните [установку][1];
* После выполнения данных настроек выполните [настройку][2].

Ключ доступа
------------

1. Получите токен сообщества:
    * перейдите в настройки сообщества;
    * Включите сообщения сообщества.
1. Перейдите в ”Работа с API”;
1. Создайте ключ сообщества;
1. Вставьте ключ в поле "ACCESS_TOKEN", в пользовательских настройках.

Настройки сообщества
------------

1. Перейдите в ”Работа с API”;
1. Выберите "Callback API";
1. ведите URL-адрес до файла "index.php" который находиться в папки с ботом;
1. Скопируйте *строку которую должен вернуть сервер*;
1. Вставьте в поле "CONFIRMATION_TOKEN", в пользовательских настройках;
1. Подтвердите сервер.

Настройки событий
------------

1. В "Типах событий", выберите:
   * Сообщения: `*Входящие сообщения*`;
   
[0]: index.md
[1]: install.md
[2]: Configuration.md