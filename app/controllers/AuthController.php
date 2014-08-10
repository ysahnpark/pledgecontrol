<?php

/**
 * @Tutorial
 * Auth Controller for authetnication
 * Notice app/routes.php maps using Route::controller
 * The method is prefixed by the HTTP method name
 *
 * Taken from: http://net.tutsplus.com/tutorials/php/authentication-with-laravel-4/
 */
class AuthController extends BaseController { 

    // The service object
    protected $userService;

    /**
     * If you look at the BaseController, you will notice that the 
     * setupLayout() method will 
     */
    protected $layout = 'layouts.workspace';

    /**
     * @Tutorial
     * Filter for guaring agains CSFR, and for protecting private pages. 
     */
    public function __construct() {
        $this->addBreadcrumb(['Siginin']);
        $this->setContentTitle('Signin' );

        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('getDashboard')));
        //$this->authService = App::make('svc:auth_service');
    }

    /**
     * Show Login form
     * `/auth/signup` instead of `/login`
     */
    public function getSignup() {
        $this->layout->content = View::make('auth.signup');
    }

    /**
     * Show Login form
     * Note: You must customize the default behavior of redirecting to /login
     * by modifying the file app/filters.php with 'auth' filter that returns
     * `/auth/signin` instead of `/login`
     */
    public function getSignin() {
        $this->layout->content = View::make('auth.signin');
    }

    /**
     * Do Logout
     */
    public function getSignout() {
        Auth::logout();
        return Redirect::to('auth/signin')
            ->with('message', 'Your have logged out!');
    }

    /**
     * Do Login
     */
    public function postSignin()
    {
        //$password = \Hash::make( Input::get('password') );
        $password = Input::get('password');
        $login_id = Input::get('login_id');

        $attempt_input = array('password' => $password);

        if (filter_var($login_id, FILTER_VALIDATE_EMAIL)) {
            $attempt_input['email'] = $login_id;
        } else {
            $attempt_input['id'] = $login_id;
        }
        

        if (Auth::attempt($attempt_input)) {
            //return Redirect::to('auth/dashboard')->with('message', 'You are now logged in!');
            return Redirect::to('users');
        } else {
            Log::debug('Signin attempt failed.');
            Session::flash('message', 'Your username/password combination was incorrect! [' . Input::get('email') .  ']= ' . Input::get('password'));
            return Redirect::to('auth/signin')
              ->withInput();
        }
    }

    /**
     * Do Sign up
     */
    public function postSignup() {
        $data = Input::all();

        try {
            $data['org_sid'] = 0;

            $user = $this->userService->createUser($data);
            Session::flash('message', 'Successfully created!');
            return Redirect::to('users');
        } catch (Service\ValidationException $ve) {
            return Redirect::to('auth/signup')
                ->withErrors($ve->getObject())
                ->withInput(Input::except('password'));
        } /*catch (Exception $e) {
            return Redirect::to('auth/signup')
                ->withErrors($e->getMessage())
                ->withInput(Input::except('password'));
        }*/
    }

    /**
     * Some protected content
     */
    public function getDashboard() {
        return Redirect::to('dashboard');
    }


    /**
     * Do Logout
     */
    public function getNopermission() {
        $this->layout->content = View::make('auth.nopermission');
    }
}
