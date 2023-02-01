<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'id',
        'Description',
        'DescriptionRu',
        'CityID',
        'AreaDescription',
        'AreaDescriptionRu',
        'created_at',
        'updated_at'
    ];

    public static function getRichList($lang)
    {
        return City::all()->map(function($item) use ($lang){          
            switch ($lang) {
                case 'UA':{
                    $name = $item["Description"];
                    break;
                }
                case 'RU':{
                    $name = $item["DescriptionRu"];
                    break;
                }
                default:
                    $name = $item["Description"];
                    break;
            }

            return [
                'id' => $item->id,
                'name' => $name
            ];
        });
    }
}
