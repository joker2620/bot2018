<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Commands
 * @package  Joker2620SourceEngineCommands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine\Commands;

use joker2620\Source\API\VKAPI;
use joker2620\Source\Engine\Interfaces\CommandIntefce;
use joker2620\Source\Engine\Loger;
use joker2620\Source\Engine\ModuleCommand\CommandsTemplate;
use joker2620\Source\Engine\Setting\ConfgFeatures;
use joker2620\Source\Engine\Setting\ConfigCommands;
use joker2620\Source\Engine\Setting\SustemConfig;

/**
 * Class CSendSMS
 *
 * @category Commands
 * @package  Joker2620SourceEngineCommands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class CSendSMS extends CommandsTemplate implements CommandIntefce
{
    /**
     * Тестовый режим
     *
     * В этом режиме сообщения не уйдут дальше сервиса sms.ru
     */
    private $_testMode = true;//Тестовый режим

    /**
     * CSendSMS constructor.
     */
    public function __construct()
    {
    }

    /**
     * Функция для запуска выполнения комманды
     *
     * @param array $item Данные пользователя.
     *
     * @see \ConfigCommands::PHONE_NUMBER База телефонных номеров
     *
     * @return mixed
     */
    public function runCom($item)
    {
        if (ConfgFeatures::getConfig()['ENABLE_SMS']) {
            $dataquery = http_build_query(
                [
                    'api_id' => ConfigCommands::getConfig()['SMSRU_API'],
                    'to' =>
                        implode(',', ConfigCommands::getConfig()['PHONE_NUMBER']),
                    'msg' => $item['matches'][2][0],
                    'json' => 1,
                    'test' => $this->_testMode //тестовый режим.
                ]
            );
            $jsonc     = $this->getCost($dataquery);
            if ($jsonc['status'] != 'ERROR') {
                $jsondata = $this->sendSms($dataquery);
                if ($jsondata['status'] == 'OK') {
                    $return = 'Сообщение: "' . $item['matches'][2][0] . '"';
                    $error  = false;
                    foreach ($jsondata['sms'] as $phone_number => $sms_message) {
                        if ('OK' != $sms_message['status']) {
                            $error = true;
                        }
                    }
                    if (!$error) {
                        $return
                            .= "\n Общая стоймость: {$jsonc['total_cost']},
                         кол-во смс: {$jsonc['total_sms']}.";
                    }
                    if ($jsondata['status'] == 'OK') { // Запрос выполнился
                        foreach ($jsondata['sms'] as $phone => $datax) {
                            if ($datax['status'] == 'OK') { // Сообщение отправлено
                                $return
                                    .= "\n - " .
                                    $phone . ': OK (ID: ' .
                                    $datax['sms_id'] . '). ';
                            } else { // Ошибка в отправке
                                $return
                                    .= "\n - " . $phone . ': НЕ ОК (Code: ' .
                                    $datax['status_code']
                                    . '. Text: ' . $datax['status_text'] . '). ';
                            }
                        }

                        $return
                            .= "\n Баланс после отправки: " .
                            $jsondata['balance'] . ' руб . ';
                    } else {
                        $return
                            .= "\n Запрос не выполнился . (Код ошибки: " .
                            $jsondata['status_code'] . '. Текст ошибки: ' .
                            $jsondata['status_text'] . '). ';
                    }
                } else {
                    Loger::getInstance()->logger('Ошибка отправки сообщений');
                    Loger::getInstance()->logger($jsondata);
                    $return = 'Ошибка отправки сообщений';
                }
            } else {
                Loger::getInstance()->logger('Ошибка получения стоймости сообщений');
                Loger::getInstance()->logger($jsonc);
                $return = 'Ошибка получения стоймости сообщений';
            }
        } else {
            $return = SustemConfig::getConfig()['MESSAGE']['TextCommand'][2];
        }
        return $return;
    }

    /**
     * Получение суммы
     *
     * @param array $dataquery Данные
     *
     * @return mixed
     */
    public function getCost($dataquery)
    {
        return json_decode(
            VKAPI::getInstance()
                ->curl(
                    'https://sms.ru/sms/cost',
                    3, $dataquery
                ), true
        );
    }

    /**
     * ОТправка сообщений
     *
     * @param array $dataquery Данные
     *
     * @return mixed
     */
    public function sendSms($dataquery)
    {
        return json_decode(
            VKAPI::getInstance()->curl(
                'https://sms.ru/sms/send',
                3, $dataquery
            ), true
        );
    }
}
