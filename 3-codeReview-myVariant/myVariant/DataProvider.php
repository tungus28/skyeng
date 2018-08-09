<?php

namespace AntKoff\Skyeng;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DataProvider implements DataProviderInterface
{
     /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }
	
	/**
     * @inheritdoc
     */
	public function sendRequest()
	{
		//	
	}	
    /**
     * @inheritdoc
     */
    public function getResponse(array $request) : array
    {
        $requestObj = $this->transformRequest($request);
		
        $responseObj = $this->sendRequest();
		
        return $this->transformResponse($responseObj);
    }
	
    /**
     * @param array $request
     * @return RequestInterface
     */
    private function transformRequest(array $request) : RequestInterface
    {
        //transformation
    }
    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function transformResponse(ResponseInterface $response) : array
    {
        //transformation
    }
}
