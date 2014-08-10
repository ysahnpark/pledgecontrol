<?php
/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */

/**
 * Copy this file to app/database/seeds directory.
 * Add the line $this->call('RoleTableSeeder');
 * into the DatabaseSeeder.php's run() method.
 * To run the migration script do: $php artisan db:seed
 */
class RolesTableSeeder extends Seeder {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function run()
	{
	    // @codgen: Uncomment this  if you want deletion first
	    //DB::table('roles')->delete();
	    $now = new \DateTime;
        $now_str = $now->format('Y-m-d H:i:s');
	    $roles = array(
            array(
			'sid' => 1,
			'uuid' => 'uuid',
			'domain_sid' => 1,
			'domain_id' => 'domain_id',
			'created_by' => 1,
			'created_dt' => new DateTime,
			'updated_by' => 1,
			'updated_dt' => new DateTime,
			'update_counter' => 'update_counter',
			'lang' => 'lang',
			'subject_type' => 'subject_type',
			'name' => 'name',
			'params_text' => 'params_text',
            )
        );
        // @codgen: Uncomment this if you want to use the DB::table API
        //DB::table('roles')->insert($roles);
        $roleSvc = new \Service\RoleService();
        foreach ($roles as $role) {
            $roleSvc->createRole($role);
        }

	}
}