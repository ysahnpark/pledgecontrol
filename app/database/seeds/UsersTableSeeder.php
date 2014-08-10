<?php

/** 
 * @Tutorial - To seed a table
 *             Remember to add this class to the DatabaseSeeder.php as:
 *             $this->call('UsersTableSeeder');
 */

/** 
 * @Tutorial - To seed a table
 */
class UsersTableSeeder extends Seeder {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        $now = new \DateTime;
        $now_str = $now->format('Y-m-d H:i:s');
        $users = array(
            array(
            'id' => 'admin',
            'password' => 'admin',
            'first_name' => 'Admin',
            'middle_name' => '',
            'last_name' => 'Site',
            'lc_name' => '',
            'display_name' => 'Site Admin',
            'phone' => '',
            'email' => 'admin@mysite.com',
            'permalink' => '',
            'activation_code' => 'host',
            'security_question' => 'Who am I?',
            'security_answer' => 'the host',
            'session_timestamp' => null,
            'last_session_ip' => '127.0.0.1',
            'last_session_dt' => $now_str,
            'login_fail_counter' => 0,
            'active' => true,
            'status' => 1,
            'default_lang_cd' => 'en',
            'timezone' => 'America/New_York',
            'expiry_dt' => null,
            'type' => 'admin',
            'params_text' => ''
            ),
            array(
            'id' => 'keeper',
            'password' => 'keeper',
            'first_name' => 'Keeper',
            'middle_name' => '',
            'last_name' => 'Site',
            'lc_name' => '',
            'display_name' => 'Site Keeper',
            'phone' => '',
            'email' => 'keeper@mysite.com',
            'permalink' => '',
            'activation_code' => 'keeper',
            'security_question' => 'Who am I?',
            'security_answer' => 'the keeper',
            'session_timestamp' => null,
            'last_session_ip' => '127.0.0.1',
            'last_session_dt' => $now_str,
            'login_fail_counter' => 0,
            'active' => true,
            'status' => 1,
            'default_lang_cd' => 'en',
            'timezone' => 'America/New_York',
            'expiry_dt' => null,
            'type' => 'keeper',
            'params_text' => ''
            )
        );

        $userDao = new \Altenia\Ecofy\CoreService\UserDaoEloquent();
        $userSvc = new \Altenia\Ecofy\CoreService\UserService($userDao);
        foreach ($users as $user) {
            $userSvc->createUser($user);
        }

    }
}