Информация
------------

* Документ поддерживается в версиях(ии): 1.0.2;
* [Создание команд][2];
* [Пример класса команд][1];
* [Главная страница][0].


$this->user
------------

Данные о пользователе. 
Функции класса User():

```php
$this->user->getId();//Получить uid пользователя
$this->user->getFirstName();//получить имя пользователя
$this->user->getLastName();//получить фамилию пользователя
$this->user->getInfo();//прочие переменные
$this->user->getMessageData();//получить данные из сообщения пользователя
```

Пример работы:

```php
$this->user->getId();
```

$this->loger
------------

Пример работы:
```php
$this->loger->logger('Кто-то запустил сверх тайную команду...');
```

$this->vkapi
------------

Работа с API ВКонтакте, а также получение данных с других сайтов (CURL GET)

Пример работы:

```php
$this->vkapi->curlGet('https://example.com/');
```

$this->dataBase
------------

* Вы можете сохранять необходимую информацию в базу данных.
 Доступные ячейки для сохранения указаны в системных настройках.

Функции класса UserData():

```php
$this->dataBase->write($name, $param = '');//Заполнить переменную
$this->dataBase->read($name);//Прочитать переменную
```

Использование внутри класса команды:
```php
    public function runCommand(array $matches)
    {
        $this->dataBase->addVar('var1', $matches[1][0]);//Записать
        $user_name = $this->dataBase->getVar('var1');//Получить
        ...
    }
```

[0]: index.md
[1]: exampleCommand.md
[2]: CreateCommands.md