<?php
/**
 * Created by PhpStorm.
 * User: v5
 * Date: 2015/11/25
 * Time: 13:43
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model{

    protected $table = 'hospital';

    protected $fillable = ['name','description','location','phone','district','photo'];

    public $timestamps = false;

    public function getHospitalsByDistrict($district)
    {
        return Hospital::where('district', $district);
    }

}