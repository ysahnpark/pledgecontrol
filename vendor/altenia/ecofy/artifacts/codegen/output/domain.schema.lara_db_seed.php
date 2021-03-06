<?php
/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */

/**
 * Copy this file to app/database/seeds directory.
 * Add the line $this->call('DomainTableSeeder');
 * into the DatabaseSeeder.php's run() method.
 * To run the migration script do: $php artisan db:seed
 */
class DomainsTableSeeder extends Seeder {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function run()
	{
	    // @codgen: Uncomment this  if you want deletion first
	    //DB::table('domains')->delete();
	    $now = new \DateTime;
        $now_str = $now->format('Y-m-d H:i:s');
	    $domains = array(
            array(
			'sid' => 1,
			'creator_sid' => 1,
			'created_dt' => new DateTime,
			'updated_by' => 1,
			'updated_dt' => new DateTime,
			'update_counter' => 'update_counter',
			'uuid' => 'uuid',
			'lang' => 'lang',
			'owner_sid' => 1,
			'parent_sid' => 1,
			'category_sid' => 1,
			'id' => 'id',
			'name' => 'name',
			'name_lc' => 'name_lc',
			'intro' => 'intro',
			'description' => 'description',
			'logo_image_url' => 'logo_image_url',
			'cover_image_url' => 'cover_image_url',
			'policy' => 'policy',
			'privacy_level' => 'privacy_level',
			'type' => 'type',
			'active' => 'active',
			'status' => 1,
			'num_users' => 'num_users',
			'num_organizations' => 'num_organizations',
			'params_text' => 'params_text',
            )
        );
        // @codgen: Uncomment this if you want to use the DB::table API
        //DB::table('domains')->insert($domains);
        $domainSvc = new \Service\DomainService();
        foreach ($domains as $domain) {
            $domainSvc->createDomain($domain);
        }

	}
}
