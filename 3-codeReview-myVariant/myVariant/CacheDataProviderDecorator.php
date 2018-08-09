<?php

namespace AntKoff\Skyeng;

use DateTime;
use Psr\Cache\CacheItemPoolInterface;

class CacheDataProviderDecorator implements DataProviderInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;
    /**
     * @var DataProviderInterface
     */
    private $dataProviderInner;
    /**
     * @param DataProviderInterface  $dataProvider
     * @param CacheItemPoolInterface $cacheItemPool
     */
    public function __construct(DataProviderInterface $dataProvider, CacheItemPoolInterface $cacheItemPool)
    {
        $this->dataProviderInner = $dataProvider;
        $this->cacheItemPool = $cacheItemPool;
    }
    /**
     * @inheritDoc
     */
    public function getResponse(array $request) : array
    {
        $cacheKey = $this->getCacheKey($request);
        $cacheItem = $this->cacheItemPool->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }
        $response = $this->dataProviderInner->getResponse($request);
        $cacheItem
            ->set($response)
            ->expiresAt((new DateTime())->modify('+1 day'));
        return $response;
    }
    /**     
     * @param array $input
     * @return string
     */
    private function getCacheKey(array $input) : string
    {
        return 'dataProvider:'.md5($input);
    }
}
