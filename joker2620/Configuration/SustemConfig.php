<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category Config
 * @package  Configuration
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
use joker2620\Source\BotFunction;

/**
 * Конфиурация
 */
$config = [
    /**
     * Адрес генератора голосовых сообщений
     *
     * Данный адрес используеться для генерации голосовых сообщений
     */
    'YA_ENDPOINT' => 'https://tts.voicetech.yandex.net/generate',
    /**
     * API Antigate
     *
     * Адрес куда отправлять капчу.
     */
    'DOMAIN_ANTI_CAPTCHA_SEND' => 'http://antigate.com/in.php',
    /**
     * Откуда брать.
     *
     * Адрес откуда брать капчу.
     */
    'DOMAIN_ANTI_CAPTCHA_GET' => 'http://antigate.com/res.php',


    /**
     * База стандартх ответов
     *
     * В этой переменной храняться стандартные ответы, используемые ботом.
     * Массив Main - переменные бота
     * Массив TextMessage - переменные используемые в классах
     * THMessage,THMessageBase, TrainingEdit
     * Массив TextCommand- переменные используемые в классах THCommands
     *
     * @see \THMessage Класс обработки текстовых сообщений
     * @see \THMessageBase Алгоритмы класса THMessage
     * @see \TrainingEdit Операции с пользовательской базой
     * @see \THCommands Класс обработки текстовых команд.
     */
    'MESSAGE' => [
        'Main' => [
            'Чтоб посмотреть список доступных команд  напишите: "команды".',
            'Крякнула уточка, крякнул и бот :)'
        ],
        'TextMessage' => [
            'Не знаю что и ответить...',
            'Подскажи, что нужно ответить на вопрос: "%s", 
             или напиши "Нет", напиши "!мусор" и сообщение будет удалено.',
            'Я не принимаю ответы мнее 6 символ, попробуй еще разок!',
            'Нет ответа на вопрос "%s", спроси что-нибудь другое.',
            'Спасибо за ответ, ты помогаешь мне стать умнее)',//Спасибо за обучение
            ' ',//от кого ответ.  [Ответ дал(а) %s] [Ответ добавил %s %s],
            //первое %s - имя, второе фамиля
            'Ну и зря, я ведь так становлюсь умнее... :(',
            'Кто-то спросил: "%s", что мне ответить в следующий раз? Дай ответ, сказажи "нет", или напиши "!мусор"', //дообучение
            'Пока ничего нет',
            'Сообщение удалено'

        ],
        'TextCommand' => [
            'Нельзя пользоваться командами для бесед, в личке',
            'у вас нет правна исполнение команд администраторов',//Нет прав
            'Извините, но данная функция отключена администратором.'
        ]
    ],
    /**
     * Версия бота
     *
     * Версия бота, указываеться вручную разработчиком бота
     */
    'VERSION' => '0.2.0',//Версия бота
    /**
     * Сборка бота
     *
     * Сборка бота, указываеться вручную разработчиком бота
     */
    'BUILD' => '22.03.18'
];//Сборка бота
/**
 * Определение местонахождения файлов
 *
 *  Тут храняться файлы бота
 */
$config['BOT']           = dirname(__DIR__);//Документы
$function                = BotFunction::getInstance();
$config['DIR_DATA']      = $function->buildPath($config['BOT'], 'data');//Корень
$config['DIR_LOG']       = $function->buildPath($config['DIR_DATA'], 'log');//Файлы
$config['DIR_IMAGES']    = $function->buildPath($config['DIR_DATA'], 'images');//Логи
$config['DIR_AUDIO']     = $function->buildPath($config['DIR_DATA'], 'audio');//Картинки
$config['DIR_DOC']       = $function->buildPath($config['DIR_DATA'], 'docs');//Аудио
$config['DIR_BASE']      = $function->buildPath($config['DIR_DATA'], 'base');//базы
$config['DIR_USER']      = $function->buildPath($config['DIR_DATA'], 'user');//базы
$config['FILE_BASE']     = $function->buildPath($config['DIR_BASE'], 'base.bin');//База слов
$config['FILE_TRAINING'] = $function->buildPath($config['DIR_BASE'], 'UserMessages.json');//База обучений

return $config;
