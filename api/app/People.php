<?php
/**
 * Class People
 *
 *
 * @OA\Schema(
 *     title="People model",
 *     type="object",
 *     description="People model",
 * )
 */
 
namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $table = 'people';
    protected $primaryKey = 'id_person';
    protected $fillable = ['name'];
    
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
     *     description="Name",
     *     title="Name",
     * )
     *
     * @var string
     */
    protected $name;
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
        'name' => 'required|max:100',
    ];
    
    public $updateRules = [
        'name' => 'required|max:100',
    ];
}
