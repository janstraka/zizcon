<?php

namespace Routers;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{

    /**
     * @return \Nette\Application\IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList();
        //$router[] = new Route('index.php', 'Front:Default:default', Route::ONE_WAY);

        // AdminModule
        $router[] = $adminRouter = new RouteList('Admin');
        $adminRouter[] = new Route('a/<presenter>/<action>', 'Admin:default');

        // BaseModule
        $router[] = $frontRouter = new RouteList('Base');
        $frontRouter[] = new Route('base/<presenter>/<action>[/<id>]', 'Default:default');

        // FrontModule
        $router[] = $frontRouter = new RouteList('Front');

        $frontRouter[] = new Route('<presenter>/<action>[/<id>]', array(

            'presenter' => array(
                Route::VALUE => 'About',
                Route::FILTER_TABLE => array(
                    'umisteni' => 'Location',
                    'listky' => 'Tickets',
                    'pravidla-ucasti' => 'Rules',
                    'hry' => 'Game',
                    'rezervace' => 'RegCheck',

                ),
            ), 'action' => array(
                Route::VALUE => 'default',
                Route::FILTER_TABLE => array(
                    'deskovky' => 'board'
                ),
            ),
            'id' => NULL,));

        return $router;
    }

}
