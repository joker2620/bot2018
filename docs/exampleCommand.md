
Информация
------------

* Документ поддерживается в версиях(ии): 1.0.1;
* [Создание команд][1];
* [Главная страница][0].

 Пример класса команды
------------

Файл: `joker2620/Source/Commands/CEncode.php`:

```php
<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class CEncode
 *
 * @package joker2620\Source\Commands
 */
class CEncode extends CommandsTemplate
{
    /*
     * Регулярное выражение по которому будет определена команда и ее аргументы
     */
    protected $regexp = 'закодируй (.{1,1000})';
    /*
     * То как будет выводиться команда в списке команд
     */
    protected $display = ' - "закодируй (текст < 1 тыс. символ)" - закодирует сообщение.';
    /*
     * Права доступа, 1 – только для администраторам, 0 – для всех пользователей
     */
    protected $permission = 0;


    /**
     * Тело команды
     *
     * runCommand()
     *
     * @param array $matches
     *
     * @return string
     */
    public function runCommand(array $matches)
    {
        $message = base64_encode($matches[1][0]);
        return $message;
    }
}
```

[0]: index.md
[1]: CreateCommands.md