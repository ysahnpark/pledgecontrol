<?php
/**
 * Models from schema: market version 0.1
 * Code generated by TransformTask
 *
 */

class Transaction extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trans';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'ID';

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
    protected $fillable = array('ID', 'AccountID', 'Name',
        'Amount', 'PaymentDate', 'Note');

    /**
     * Validation rules for creation
     *
     * @var array
     */
    private static $validation_rules_create = array(
        'AccountID' => 'required',
        'Amount' => 'numeric'
        );

    /**
     * Validation rules for update
     *
     * @var array
     */
    private static $validation_rules_udpate = array(
        'AccountID' => 'required',
        'Amount' => 'numeric'
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

    public function account()
    {
        return $this->belongsTo('Account', 'AccountID', 'ID');
    }
    
    public function getName()
    {
        return $this->Amount;
    }
}
