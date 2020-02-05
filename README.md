# Customer Backup And Delete

Adds a button to transfer a customer's order to a new fake one, which allows the former to be deleted.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is CustomerBackupAndDelete.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/customer-backup-and-delete-module:~1.0.0
```

## Usage

A new button "Transfer customer's orders" is added in the customer edit page. Clicking it tranfers all
orders from this customer to a new one, automatically created at module startup, with reference "BACKUPORDERS".
This allows the old customer to be deleted.

## /!\ /!\ /!\ WARNING /!\ /!\ /!\
Keep in mind that this action is irreversible and should only be done if you intend to delete the customer you
remove the orders from !