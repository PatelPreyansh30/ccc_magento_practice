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

            $nonDiscontinueItems = array_intersect($this->getPartNumberArray(), $existingDiscontinuePart);
            $newItems = array_diff($this->getPartNumberArray(), $masterData);
            $discontinueItems = array_diff($masterData, $this->getPartNumberArray());

            if (!empty($nonDiscontinueItems)) {
                foreach ($nonDiscontinueItems as $_discontinue) {
                    Mage::getModel('ccc_ftp/discontinuepart')
                        ->load($_discontinue, 'part_number')
                        ->delete();
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
        }
    }
}
