<?php

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\Integration\DataProvider;

/**
 * todo не соответствует шаблону проектирования Decorator
 * todo не реализуется нужный функционал 
 * todo не соответствует первому принципу SOLID (класс занимается и кэшированием и логированием)
 */
 
class DecoratorManager extends DataProvider //todo реализовать \Psr\Log\LoggerAwareInterface
{
    //todo использовать \Psr\Log\LoggerAwareTrait
    //todo добавить phpDoc, не использовать public
    public $cache;
    public $logger;
    /**
     * todo убрать зависимость от реализации родителя
     * @param string $host
     * @param string $user
     * @param string $password
     * @param CacheItemPoolInterface $cache
     */
    public function __construct($host, $user, $password, CacheItemPoolInterface $cache)
    {
        parent::__construct($host, $user, $password);
        $this->cache = $cache;
    }
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * todo тип возвращаемого значаения
     * todo называться должен как у родителя - get()
     * {@inheritdoc}
     */
    public function getResponse(array $input)
    {
        try { //todo убрать лишний функционал
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
            $result = parent::get($input); //todo переименовать метод
            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify('+1 day')
                );
            return $result;
        } catch (Exception $e) {
            /**
             * todo - не понятно, critical или error
             */
            $this->logger->critical('Error');
        }
        return [];
    }
    /**
     * todo phpDoc
     * todo заменить public
     * todo return - тип данных     
     * todo лучше возвращать не сам ключ, а hash
     * todo добавить префикс ключа
     */
    public function getCacheKey(array $input)
    {
        return json_encode($input);
    }
}
