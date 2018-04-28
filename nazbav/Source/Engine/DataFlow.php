<?php
declare(strict_types = 1);


namespace nazbav\Source\Engine;

use nazbav\Source\Exception\BotError;
use nazbav\Source\Interfaces\DataFlow\DataFlowInterface;
use nazbav\Source\Setting\Config;


/**
 * Class DataFlow
 *
 * @package nazbav\Source\DataFlow
 */
class DataFlow implements DataFlowInterface
{


    /**
     * readData()
     *
     * @param array $request
     *
     * @return object
     * @throws BotError
     */
    public function readData(array $request = [])
    {
        if (empty($request)) {
            $request = json_decode(file_get_contents('php://input'), true);
        }
        if (empty($request) ||
            Config::getConfig()['GROUP_ID'] !== $request['group_id'] ||
            Config::getConfig()['SECRET_KEY'] !== $request['secret']
        ) {
            throw new BotError(Config::getConfig()['MESSAGE']['cameEmptyRequest']);
        }
        return (object)$request;
    }


    /**
     * putData()
     *
     * @param null|string $responce
     */
    public function putData(?string $responce = 'ok'): void
    {
        file_put_contents('php://output', $responce);
    }
}