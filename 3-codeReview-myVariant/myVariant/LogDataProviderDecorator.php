<?php

namespace AntKoff\Skyeng;

use Exception;
use Psr\Log\LoggerInterface;

class LogDataProviderDecorator implements DataProviderInterface
{
    /**
     * @var DataProviderInterface
     */
    private $dataProviderInner;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @param DataProviderInterface $dataProvider
     * @param LoggerInterface       $logger
     */
    public function __construct(DataProviderInterface $dataProvider, LoggerInterface $logger)
    {
        $this->dataProviderInner = $dataProvider;
        $this->logger = $logger;
    }
    /**
     * @inheritDoc
     */
    public function getResponse(array $request) : array
    {
        try {
            return $this->dataProviderInner->getResponse($request);
        } catch (Exception $e) {            
            $this->logger->error('Error: '. $e->getMessage());
            return [];
        }
    }
}
