<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/**
 * Created By : Navnit Viradiya
 */
declare (strict_types = 1);

namespace Amc\TopCategor\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
/**
 * Class CreateCustomAttr for Create Custom Product Attribute using Data Patch.
 */
class Category implements DataPatchInterface {
    /**
     * ModuleDataSetupInterface
     *
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * EavSetupFactory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory          $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }


    public function apply() {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/Catalog.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $logger->info(print("Before thumbnail_picture"));
        /* Create  attribute thumbnail_image for category*/
        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'thumbnail_picture',
            [
                'type'         => 'varchar',
                'label'        => 'Thumbnail Picture',
                'input'        => 'image',
                'backend'      => \Magento\Catalog\Model\Category\Attribute\Backend\Image::class,
                'sort_order'   => 110,
                'source'       => '',
                'global'       => 1,
                'visible'      => true,
                'required'     => false,
                'user_defined' => false,
                'default'      => null,
                'group'        => '',

            ]
        );
        $logger->info(print("After thumbnail_picture"));
        // Create attribute top_category for category /
        $logger->info(print("Before best_category"));
        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'best_category',
            [
                'type'         => 'varchar',
                'label'        => 'Best Category',
                'input'        => 'boolean',
                'sort_order'   => 100,
                'source'       => '',
                'global'       => 1,
                'visible'      => true,
                'required'     => false,
                'user_defined' => false,
                'default'      => null,
                'group'        => '',
                'backend'      => ''
            ]
        );
        $logger->info(print("After best_category"));
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies() {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases() {
        return [];
    }
}