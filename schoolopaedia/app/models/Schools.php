<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Schools extends Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    protected $fillable = array(
        'school_name',
        'manager_full_name',
        'phone_number',
        'email',
        'add_1',
        'add_2',
        'city',
        'state',
        'country',
        'pin_code',
        'registration_code',
        'code_for_admin',
        'code_for_moderators',
        'code_for_teachers',
        'code_for_parents',
        'code_for_students',
        'registration_date',
        'logo',
        'active',
    );

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'schools';

    /**
     * for the foreign key permissions to the classes table
     */
    public function classes() {
        return $this->hasmany('Classes', 'school_id', 'id');
    }

}
