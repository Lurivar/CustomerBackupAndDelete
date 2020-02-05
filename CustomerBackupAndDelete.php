<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace CustomerBackupAndDelete;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Propel;
use Thelia\Install\Database;
use Thelia\Model\Customer;
use Thelia\Model\CustomerQuery;
use Thelia\Model\CustomerTitleQuery;
use Thelia\Model\LangQuery;
use Thelia\Module\BaseModule;

class CustomerBackupAndDelete extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'customerbackupanddelete';

    /*
     * You may now override BaseModuleInterface methods, such as:
     * install, destroy, preActivation, postActivation, preDeactivation, postDeactivation
     *
     * Have fun !
     */

    public function postActivation(ConnectionInterface $con = null) {
        if (null === CustomerQuery::create()->findOneByRef('BACKUPORDERS')) {
            try {
                $baseTitle = CustomerTitleQuery::create()->firstCreatedFirst()->findOne()->getId();
                $baseLang = LangQuery::create()->firstCreatedFirst()->findOne()->getId();

                $lastCustomer = CustomerQuery::create()->orderById(Criteria::DESC)->findOne();
                $newId = $lastCustomer->getId() + 1;

                $query = "
                    INSERT INTO customer(id, ref, title_id, firstname, lastname, lang_id, email, created_at, updated_at, version_created_at)
                    VALUES ($newId, 'BACKUPORDERS', $baseTitle, 'Orders', 'Backup', $baseLang, ' ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00')
                    ";

                $con = Propel::getConnection();
                $stmt = $con->prepare($query);
                $stmt->execute();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}
