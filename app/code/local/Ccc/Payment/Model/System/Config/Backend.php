<?php
class Ccc_Payment_Model_System_Config_Backend extends Mage_Core_Model_Config_Data
{
    public function getCommentText(Mage_Core_Model_Config_Element $element, $currentValue)
    {
        return Mage::helper('ccc_payment')->__('Define your custom shipping methods and prices here.');
    }
    protected function _beforeSave()
    {
        $value = $this->getValue();
        $last = 0;
        foreach ($value as $option) {
            if ($option['from']!=null) {
                if ($option['from'] != $last) {
                    Mage::throwException(Mage::helper('ccc_payment')->__('check number'));
                }

                $last = $option['to'];
            }
        }

        usort($value, function ($a, $b) {
            if ($a['from'] == $b['from']) {
                return 0;
            }
            return ($a['from'] < $b['from']) ? -1 : 1;
        });
        $lastToValue = 0;
        foreach ($value as $option) {
            if ($option['from'] < $lastToValue) {
                Mage::throwException(Mage::helper('ccc_payment')->__('Value error: The "from" value of the second option cannot be lower than the "to" value of the first option.'));
            }

            $lastToValue = $option['to'];
        }

        if (is_array($value)) {
            $value = array_filter($value);
            if (!empty($value)) {
                $serializedValue = serialize($value);
                $this->setValue($serializedValue);
            } else {
                $this->setValue(null); 
            }
        }
        return parent::_beforeSave();
    }
    protected function _afterLoad()
    {
        $value = $this->getValue();
        if (!is_array($value)) {
            $unserializedValue = unserialize($value);
            $this->setValue($unserializedValue);
        }
        return parent::_afterLoad();
    }
}
