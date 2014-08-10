<%namespace name="common" file="/codegen_common.tpl"/><%
    def get_sample_val(field):
        type = field['type']
        if (type == 'auto'):
            return 1
        elif (type == 'int'):
            return 1
        elif (type == 'long'):
            return 1
        elif (type == 'datetime'):
            return 'new DateTime'
        endif
        return "'" + field['name'] + "'"

%><?php
/**
 * Models from schema: ${ model['schema-name'] } version ${ model['version'] }
 * Code generated by ${params['TASK_TYPE_NAME']}
 *
 */

% for entity_name, entity_def in model['entities'].iteritems():
/**
 * Copy this file to app/database/seeds directory.
 * Add the line $this->call('${entity_name.capitalize()}TableSeeder');
 * into the DatabaseSeeder.php's run() method.
 * To run the migration script do: $php artisan db:seed
 */
class ${common.to_camelcase(common.get_plural(entity_name, True))}TableSeeder extends Seeder {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function run()
	{
	    // @codgen: Uncomment this  if you want deletion first
	    //DB::table('${common.get_plural(entity_name)}')->delete();
	    $now = new \DateTime;
        $now_str = $now->format('Y-m-d H:i:s');
	    $${common.get_plural(entity_name)} = array(
            array(
% for field in entity_def['fields']:
			'${field["name"]}' => ${get_sample_val(field)},
% endfor
            )
        );
        // @codgen: Uncomment this if you want to use the DB::table API
        //DB::table('${common.get_plural(entity_name)}')->insert($${common.get_plural(entity_name)});
        $${entity_name}Svc = new \Service\${common.to_camelcase(entity_name, True, False)}Service();
        foreach ($${common.get_plural(entity_name)} as $${entity_name}) {
            $${entity_name}Svc->create${common.to_camelcase(entity_name, True, False)}($${entity_name});
        }

	}
}
% endfor