<?php

namespace Botble\Announcementadmin\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;
use Botble\Announcementadmin\Models\Announcementadmin;
use Botble\Base\Facades\EmailHandler;
use Illuminate\Routing\Events\RouteMatched;
class AnnouncementadminServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
       
        $this
            ->setNamespace('plugins/announcementadmin')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions','email'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();

            $this->app->register(EventServiceProvider::class);
        
            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Announcementadmin::class, [
                    'name',
                ]);
            }
            
            // DashboardMenu::default()->beforeRetrieving(function () {
            //     DashboardMenu::registerItem([
            //         'id' => 'cms-plugins-announcementadmin',
            //         'priority' => 5,
            //         'parent_id' => null,
            //         'name' => 'plugins/announcementadmin::announcementadmin.name',
            //         'icon' => 'ti ti-box',
            //         'url' => route('announcementadmin.index'),
            //         'permissions' => ['announcementadmin.index'],
            //     ]);
            // });
          
            $this->app['events']->listen(RouteMatched::class, function (): void {
                EmailHandler::addTemplateSettings(ANNOUNCEMENTADMIN_MODULE_SCREEN_NAME, config('plugins.announcementadmin.email', []));
            });
         
    }
}
