<?php namespace Altenia\Ecofy\CoreService;

use Illuminate\Database\Eloquent\Model;

/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */

class Profile extends Model {

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'users';

    /**
	 * The primary key column name.
	 *
	 * @var string
	 */
	protected $primaryKey = 'sid';

	/**
	 * To disable created_at and updated_at.
	 *
	 * @var boolean
	 */
	public $timestamps = false;


    /**
	 * The field list for mass assignment.
	 *
	 * @var array
	 */
    protected $fillable = array('uuid','domain_sid','domain_id','created_by','created_dt','updated_by','updated_dt','update_counter','lang','user_sid','first_name','middle_name','last_name','lc_name','alt_name','primary_lang','nationality_cd','hometown','gender','dob','education_level','highlight','philosophy','goals','personality_type','location','country_cd','province_cd','district','address','postal_code','privacy_level','activity_index','params_text');

    /**
     * Validation rules for creation
     *
     * @var array
     */
    private static $validation_rules_create = array(
        'first_name' => 'required|min:2',
		'primary_lang' => 'min:2|max:3',
		'nationality_cd' => 'min:2|max:3',
		'hometown' => 'required|min:2',
		'country_cd' => 'min:2|max:3'
    	);

    /**
     * Validation rules for update
     *
     * @var array
     */
    private static $validation_rules_udpate = array(
        'first_name' => 'required|min:2',
		'primary_lang' => 'min:2|max:3',
		'nationality_cd' => 'min:2|max:3',
		'hometown' => 'required|min:2',
		'country_cd' => 'min:2|max:3'
    	);

    /**
     * Returns the validation object
     */
    public static function validator($fields, $is_create = true)
    {
    	$rules = ($is_create) ? static::$validation_rules_create : static::$validation_rules_update;
        $validator = Validator::make($fields, $rules);

        return $validator;
    }

    public function organizations()
    {
        return $this->belongsTo('Organizations');
    }
}
