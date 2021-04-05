<?php

namespace Amasty\Course\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable($setup->getTable('amasty_product_blacklist'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Entity Id'
            )
            ->addColumn(
                'product_sku',
                Table::TYPE_TEXT,
                '64',
                [
                    'nullable' => false,
                    'default' => ''
                ],
                'Product SKU'
            )
            ->addColumn(
                'product_qty',
                Table::TYPE_DECIMAL,
                12,
                [
                    'nullable' => true,
                    'default' => null
                ],
                'Product Qty'
            )
            ->setComment('Amasty Blacklist Table');
        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
