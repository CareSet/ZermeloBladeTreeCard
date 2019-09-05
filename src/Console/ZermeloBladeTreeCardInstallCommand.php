<?php

namespace CareSet\ZermeloBladeTreeCard\Console;

use CareSet\Zermelo\Console\AbstractZermeloInstallCommand;

class ZermeloBladeTreeCardInstallCommand extends AbstractZermeloInstallCommand
{
    protected $view_path = __DIR__.'/../../views';

    protected $asset_path = __DIR__.'/../../assets';

    protected $config_file = __DIR__.'/../../config/zermelobladecard.php';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'zermelo/tree_card.blade.php',
        'zermelo/layouts/tree_card.blade.php',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:zermelobladetreecard
                    {--force : Overwrite existing views by default}';
}
