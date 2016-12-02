<?php

namespace Admin;

use \App;
use \View;
use \Input;
use \Sentry;
use \Response;
use \Member;

class AdminController extends BaseController
{

    /**
     * display the admin dashboard
     */
    public function index()
    {

        // echo '<pre>';
        // print_r( $this->data['accountAdmin'] );
        // echo '</pre>';
        // die();

        View::display('admin/common/index.twig', $this->data);
    }

    /**
     * display the login form
     */
    public function login()
    {
        if(Sentry::check()){
            Response::redirect($this->siteUrl('admin'));
        }else{

            $this->resetCss();
            $this->resetJs();

            $this->loadCss("bootstrap.min.css");
            $this->loadCss("font-awesome.min.css");
            $this->loadCss("https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" , array( 'location' => 'external' ));
            $this->loadCss("assets/global/plugins/simple-line-icons/simple-line-icons.min.css" , array( 'location' => 'external' ));
            $this->loadCss("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" , array( 'location' => 'external' ));
            $this->loadCss("assets/global/plugins/select2/css/select2.min.css" , array( 'location' => 'external' ));
            $this->loadCss("assets/global/plugins/select2/css/select2-bootstrap.min.css" , array( 'location' => 'external' ));
            $this->loadCss("assets/global/css/components.min.css" , array( 'location' => 'external' ));
            $this->loadCss("assets/global/css/plugins.min.css" , array( 'location' => 'external' ));
            $this->loadCss("assets/pages/css/login-5.min.css" , array( 'location' => 'external' ));

            $this->loadJs("jquery-1.10.2.js");
            $this->loadJs("bootstrap.min.js");
            $this->loadJs("assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" , array( 'location' => 'external' ));
            $this->loadJs("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" , array( 'location' => 'external' ));
            $this->loadJs("assets/global/plugins/jquery.blockui.min.js" , array( 'location' => 'external' ));
            $this->loadJs("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" , array( 'location' => 'external' ));
            $this->loadJs("assets/global/plugins/jquery-validation/js/jquery.validate.min.js" , array( 'location' => 'external' ));
            $this->loadJs("assets/global/plugins/jquery-validation/js/additional-methods.min.js" , array( 'location' => 'external' ));
            $this->loadJs("assets/global/plugins/select2/js/select2.full.min.js" , array( 'location' => 'external' ));
            $this->loadJs("assets/global/plugins/backstretch/jquery.backstretch.min.js" , array( 'location' => 'external' ));
            $this->loadJs("assets/pages/scripts/login-5.min.js" , array( 'location' => 'external' ));



            $this->data['redirect'] = (Input::get('redirect')) ? base64_decode(Input::get('redirect')) : '';
            View::display('admin/common/login.twig', $this->data);
        }
    }

    /**
     * Process the login
     */
    public function doLogin()
    {
        $remember = Input::post('remember', false);
        $email    = Input::post('email');
        $redirect = Input::post('redirect');
        $redirect = ($redirect) ? $redirect : 'admin';

        try{
            $credential = array(
                'email'     => $email,
                'password'  => Input::post('password')
            );

            // Try to authenticate the user
            $user = Sentry::authenticate($credential, false);

            if($remember){
                Sentry::loginAndRemember($user);
            }else{
                Sentry::login($user, false);
            }

            Response::redirect($this->siteUrl($redirect));
        }catch(\Exception $e){
            App::flash('message', $e->getMessage());
            App::flash('email', $email);
            App::flash('redirect', $redirect);
            App::flash('remember', $remember);

            Response::redirect($this->siteUrl('login'));
        }
    }

    /**
     * Logout the user
     */
    public function logout()
    {
        Sentry::logout();

        Response::redirect($this->siteUrl('login'));
    }

}