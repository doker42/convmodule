<?php

namespace Vendor\Conversion\Observer;

use Magento\Framework\Event\ObserverInterface;
use Mementia\Conversion\Controller\Convert\Convert;

class ConvertPrice implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $currency_cost = $product->getCurrency_cost();
        $costCurrency = $product->getAttributeText('currency');
        $rate_arr = Convert::getCurrencyArr();

        if($currency_cost && $costCurrency){
            foreach($rate_arr as $key => $value){
                if($costCurrency == $key) {
                    if($value){
                        $product->setPrice($value * $currency_cost);
                    }
                }
            }
        }
    }
}

