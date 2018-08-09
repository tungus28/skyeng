<?php

namespace AntKoff\Skyeng;

interface DataProviderInterface
{
    /**     
     * @param array $request
     * @return array
     */
    public function getResponse(array $request) : array;
}
