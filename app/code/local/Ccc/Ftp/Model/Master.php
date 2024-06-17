<?php
class Ccc_Ftp_Model_Master extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_ftp/master');
    }
    public function saveMaster()
    {
        if (empty($this->getCollection()->getData())) {
            foreach ($this->getXmlData() as $_data) {
                Mage::getModel('ccc_ftp/master')
                    ->setData($_data)
                    ->save();
            }
        } else {
            $masterData = $this->getCollection()->getColumnValues('part_number');
            $existingDiscontinuePart = Mage::getModel('ccc_ftp/discontinuepart')
                ->getCollection()
                ->getColumnValues('part_number');
            $existingNewPart = Mage::getModel('ccc_ftp/newpart')
                ->getCollection()
                ->getColumnValues('part_number');

            $nonDiscontinueItems = array_intersect($this->getPartNumberArray(), $existingDiscontinuePart);
            $newItems = array_diff($this->getPartNumberArray(), $masterData);
            $discontinueItems = array_diff($masterData, $this->getPartNumberArray());
            $nonNewItems = array_intersect($existingNewPart, $discontinueItems);

            if (!empty($nonNewItems)) {
                $collection = Mage::getModel('ccc_ftp/newpart')
                    ->getCollection()
                    ->addFieldToFilter('part_number', ['in' => $nonNewItems]);
                foreach ($collection as $_row) {
                    $_row->delete();
                }
            }
            if (!empty($nonDiscontinueItems)) {
                $collection = Mage::getModel('ccc_ftp/discontinuepart')
                    ->getCollection()
                    ->addFieldToFilter('part_number', ['in' => $nonDiscontinueItems]);
                foreach ($collection as $_row) {
                    $_row->delete();
                }
            }
            if (!empty($discontinueItems)) {
                foreach (array_diff($discontinueItems, $existingDiscontinuePart) as $_discontinue) {
                    $masterObj = Mage::getModel('ccc_ftp/master')
                        ->load($_discontinue, 'part_number');

                    Mage::getModel('ccc_ftp/discontinuepart')
                        ->setMasterModel($masterObj)
                        ->setRawData()
                        ->save();
                }
            }
            if (!empty($newItems)) {
                foreach ($newItems as $_new) {
                    $masterObj = Mage::getModel('ccc_ftp/master')
                        ->addData($this->getXmlData()[$_new])
                        ->save();

                    Mage::getModel('ccc_ftp/newpart')
                        ->setMasterModel($masterObj)
                        ->setRawData()
                        ->save();
                }
            }

            $updateArray = array_diff($masterData, $newItems);
            $updateArray = array_diff($updateArray, $existingDiscontinuePart);
            foreach ($updateArray as $_update) {
                if (!is_null($this->getXmlData()[$_update])) {
                    Mage::getModel('ccc_ftp/master')
                        ->load($_update, 'part_number')
                        ->addData($this->getXmlData()[$_update])
                        ->save();
                }
            }
        }
    }
}
