<?php
declare(strict_types = 1);
/**
 * File: DataFlowInterface.php;
 * Author: nazbav;
 * Date: 15.04.2018;
 * Time: 16:58;
 */

namespace nazbav\Source\Interfaces\DataFlow;


/**
 * Interface DataFlowInterface
 *
 * @package nazbav\Source\Interfaces\DataFlow
 */
interface DataFlowInterface
{


    /**
     * putData()
     *
     * @param null|string $responce
     */
    public function putData(?string $responce = 'ok'): void;


    /**
     * readData()
     *
     * @param array $request
     *
     * @return object
     */
    public function readData(array $request = []);
}