<?php

namespace Vendor\Conversion\Cron;


class Cronconvert extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
        $currencyFactory = $objectManager->get('\Magento\Directory\Model\CurrencyFactory');
        $baseCurrency = $storeManager->getStore()->getBaseCurrency()->getCode();
        $currency_arr = $storeManager->getStore()->getAvailableCurrencyCodes(true);
        $currency_arr_stat = [ "USD", "EUR", "UAH" ];
        $rate_arr = [];
        if($currency_arr && (count($currency_arr) > 1)){
            foreach($currency_arr as $item ){
                $rate_arr[$item] = $currencyFactory->create()->load($item)->getAnyRate($baseCurrency);
            }
        } else {
            foreach($currency_arr_stat as $item ){
                $rate_arr[$item] = $currencyFactory->create()->load($item)->getAnyRate($baseCurrency);
            }
        }

        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->load();

        foreach ($collection as $product){

            $currency_cost = $product->getCurrency_cost();
            $costCurrency = $product->getAttributeText('currency');

            if($currency_cost && $costCurrency){
                foreach($rate_arr as $key => $value){
                    if($costCurrency == $key) {
                        if($value){
                            $product->setPrice($value * $currency_cost);
                            $product->save();
                        }
                    }
                }
            }
        }
    }
}
