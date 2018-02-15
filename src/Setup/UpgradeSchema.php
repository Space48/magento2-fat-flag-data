<?php

namespace Space48\FatFlagData\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (\version_compare($context->getVersion(), '1.0.0', '<')) {
            $this->updateFlagDataColumn($setup->getConnection());
        }
    }

    private function updateFlagDataColumn(AdapterInterface $connection)
    {
        $tableName = $connection->getTableName('flag');
        $columnName = 'flag_data';
        $newColumnStructure = [
            'type' => Table::TYPE_TEXT,
            'length' => '16m'
        ];

        $connection->changeColumn(
            $tableName,
            $columnName,
            $columnName,
            $newColumnStructure
        );
    }
}
