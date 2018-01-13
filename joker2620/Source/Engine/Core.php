<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine;

use joker2620\Source\Exception\BotError;

/**
 * Class Core
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class Core extends HandlersEvent
{

    /**
     * Функция активации бота.
     *
     * @see    \ConfigVKAPI::SECRET_KEY Секретный ключ
     * @source 2 30 Функция активации бота.
     *
     * @return void
     * @throws BotError
     */
    public function scan()
    {
        switch ($this->data['type']) {
            //Подтверждение сервера
            case 'confirmation':
                $this->handConfirmation();
                break;
            //Получение нового сообщения
            case 'message_new':
                $this->handMessage();
                break;
            //Новый пост
            case 'wall_post_new':
                $this->wallPostNew();
                break;
            //Новый голос
            case 'poll_vote_new':
                $this->pollVoteNew();
                break;
            default:
                DataOperations::putData();
                throw new BotError(
                    '"' . $this->data['type'] .
                    '"- Этот метод не подерживаеться'
                );
                break;
        }
    }
}
