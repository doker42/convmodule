<?php

namespace Vendor\Conversion\Model\Config\Source;



class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        $this->_options = [
            ['label'=>'', 'value'=>''],
            ['label'=>'USD', 'value'=>'USD'],
            ['label'=>'EUR', 'value'=>'EUR'],
            ['label'=>'UAH', 'value'=>'UAH']
        ];
        return $this->_options;
    }

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
