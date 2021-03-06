<?php
namespace Admin;

use \App;
use \Menu;
use \Module;
use \Sentry;

class BaseController extends \BaseController
{

    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->data['menu_pointer'] = '<div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>';

        $adminMenu = Menu::create('admin_sidebar');
        $dashboard = $adminMenu->createItem('dashboard', array(
            'label' => 'Dashboard',
            'icon'  => 'dashboard',
            'url'   => 'admin'
        ));

        $this->resetCss();
        $this->resetJs();

        $this->loadCss("http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" , array( 'location' => 'external' ));
        $this->loadCss("/node_modules/font-awesome/css/font-awesome.min.css" , array( 'location' => 'external' ));
        $this->loadCss("/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" , array( 'location' => 'external' ));
        $this->loadCss("/assets/global/plugins/bootstrap/css/bootstrap.min.css" , array( 'location' => 'external' ));
        $this->loadCss("/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" , array( 'location' => 'external' ));
        $this->loadCss("/assets/global/css/components.min.css" , array( 'location' => 'external' ));
        $this->loadCss("/assets/global/css/plugins.min.css" , array( 'location' => 'external' ));
        $this->loadCss("/assets/layouts/layout/css/layout.min.css" , array( 'location' => 'external' ));
        $this->loadCss("/assets/layouts/layout/css/themes/default.min.css" , array( 'location' => 'external' ));
        $this->loadCss("/assets/layouts/layout/css/custom.css" , array( 'location' => 'external' ));

        $this->loadJs("/assets/global/plugins/jquery.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/global/plugins/bootstrap/js/bootstrap.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/global/plugins/js.cookie.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/global/plugins/jquery.blockui.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/global/scripts/app.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/layouts/layout/scripts/layout.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/layouts/layout/scripts/demo.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/layouts/global/scripts/quick-sidebar.min.js" , array( 'location' => 'external' ));
        $this->loadJs("/assets/layouts/global/scripts/quick-nav.min.js" , array( 'location' => 'external' ));

        $adminMenu->addItem('dashboard', $dashboard);
        $adminMenu->setActiveMenu('dashboard');

        // get account admin 
        $user = Sentry::getUser();
        if (! empty( $user )) {
            $this->data['accountAdmin']['first_name'] = $user->first_name;
            $this->data['accountAdmin']['last_name'] = $user->last_name;
            $this->data['accountAdmin']['email'] = $user->email;
        }

        foreach (Module::getModules() as $module) {
            $module->registerAdminMenu();
        }

    }
}