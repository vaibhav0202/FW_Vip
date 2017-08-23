<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('vip/vip')};
CREATE TABLE {$this->getTable('vip/vip')} (
  `vip_id` int(11) unsigned NOT NULL auto_increment,
  `product_sku` varchar(255) NOT NULL default '',
  `customer_group_id` int unsigned NOT NULL default 1,
  PRIMARY KEY (`vip_id`),
  UNIQUE INDEX `unique_sku` (`product_sku`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();