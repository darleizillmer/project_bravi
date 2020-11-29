<?php
/**
 * Class Contact
 *
 *
 * @OA\Schema(
 *     title="Contact model",
 *     type="object",
 *     description="Contact model",
 * )
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    public    $dbTable = 'contact';
    protected $primaryKey = 'id_contact';
    protected $fillable = ['id_person', 'phone_number', 'whatsapp_number', 'email'];
    
    /**
     * @OA\Property(
     *     format="int64",
     *     description="Id Contact",
     *     title="Id Contact",
     * )
     *
     * @var integer
     */
    protected $id_contact;
    
    /**
     * @OA\Property(
     *     format="int64",
     *     description="Id Person",
     *     title="Id Person",
     * )
     *
     * @var integer
     */
    protected $id_person;
    
    /**
     * @OA\Property(
     *     description="Phone Number",
     *     title="Phone Number",
     * )
     *
     * @var string
     */
    protected $phone_number;
    
    /**
     * @OA\Property(
     *     description="Whatsapp Number",
     *     title="Whatsapp Number",
     * )
     *
     * @var string
     */
    protected $whatsapp_number;
    
    /**
     * @OA\Property(
     *     description="Email",
     *     title="Email",
     * )
     *
     * @var string
     */
    protected $email;
    
    /**
     * @OA\Property(
     *     description="Created At",
     *     title="Created At",
     * )
     *
     * @var string
     */
    protected $created_at;
    
    /**
     * @OA\Property(
     *     description="Updated At",
     *     title="Updated At",
     * )
     *
     * @var string
     */
    protected $updated_at;
    
    public $createRules = [
        'id_person'       => 'required|numeric',
        'phone_number'    => 'required|max:30',
        'whatsapp_number' => 'required|max:30',
        'email'           => 'required|email|unique:contact',
    ];
    
    public $updateRules = [
        'phone_number'    => 'required|max:30',
        'whatsapp_number' => 'required|max:30',
        'email'           => 'required|email',
    ];
}
