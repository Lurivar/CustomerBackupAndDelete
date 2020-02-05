<?php


namespace CustomerBackupAndDelete\Controller;


use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\CustomerQuery;
use Thelia\Tools\URL;

class BackupController extends BaseAdminController
{
    public function transferOrders($id) {
        $customer = CustomerQuery::create()->findOneById($id);
        $backupCustomer = CustomerQuery::create()->findOneByRef('BACKUPORDERS');

        if (null !== $orders = $customer->getOrders()) {
            foreach ($orders as $order) {
                $order->setCustomerId($backupCustomer->getId())->save();
            }
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/customer/update?customer_id=$id"));
    }
}