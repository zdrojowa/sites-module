<?php

namespace Selene\Modules\SitesModule;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Selene\Modules\SitesModule\Models\Site;
use Selene\Modules\SitesModule\Support\ContentHelper;

/**
 * Class SitesModuleServiceProvider
 * @package Selene\Modules\SitesModule
 */
class SitesModuleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');


        Blade::directive('var', function($var) {
            return '<?php echo $site->getContent('.$var.'); ?>';
        });

        Blade::directive('group', function($group) {
            return '
                <?php
                    $_group = $site->getContent('.$group.');
                    
                    if($_group === null) $_group = [];
                    
                    $_group = collect($_group);
                    
                    foreach($_group->sortBy("_order") as $index => $item):
                        $item = collect($item);
                        $item = $item->mapWithKeys(function($itemContent, $key) {
                            switch($key) {
                                case "_name":
                                case "_active":
                                case "_order":
                                    return [$key => $itemContent];
                                    break;
                                default:
                                    return [camelcase($key) => $itemContent];
                                    break;
                            }
                        });
                        
                        $item = (object) $item->toArray();   
                ?>
            ';
        });

        Blade::directive('endgroup', function() {
            return '<?php endforeach; ?>';
        });
    }

}
