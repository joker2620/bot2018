<?php

declare(strict_types=1);
/**
 * File: DataFlowInterface.php;
 * Author: Joker2620;
 * Date: 15.04.2018;
 * Time: 16:58;.
 */

namespace joker2620\Source\Interfaces\DataFlow;

/**
 * Interface DataFlowInterface.
 */
interface DataFlowInterface
{
    /**
     * putData().
     *
     * @param null|string $responce
     */
    public function putData(?string $responce = 'ok'): void;

    /**
     * readData().
     *
     * @param array $request
     *
     * @return object
     */
    public function readData(array $request = []);
}
