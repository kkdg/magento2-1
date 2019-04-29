<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Blackbox\SmartModule\Setup\Patch\Data;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\FlagManager;
use Magento\Framework\Math\Random;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Patch is mechanism, that allows to do atomic upgrade data changes
 */
class PrepareInitialConfig implements
    DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var Random
     */
    private $randomMath;

    /**
     * @var FlagManager
     */
    private $flagManager;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ConfigInterface $config
     * @param Random $random
     * @param FlagManager $flagManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ConfigInterface $config,
        Random $random,
        FlagManager $flagManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->config = $config;
        $this->randomMath = $random;
        $this->flagManager = $flagManager;
    }

    /**
     * Do Upgrade
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply()
    {
        $this->config->saveConfig(
            'smartmodule/generator/random_key',
            $this->randomMath->getRandomString(10),
            'default',
            '0'
        );
        $this->flagManager->saveFlag(
            'blackbox_flag_v_2_0_0',
            __CLASS__  . __FUNCTION__
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
}
