<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\NovaPoshtaHelper;
use App\Models\City;

class HomeController extends Controller
{
    public function index($lang = 'UA')
    {
        $lables = [
            'UA' => [
                'select_city' => 'Оберіть місто:',
                'select_departament' => 'Оберіть відділення:',
                'enter_price' => 'Введіть вартість посилки:',
                'count' => 'Вартість пересилки:',
                'departement_not_found' => 'В місті немає відділень.'
            ],
            'RU' => [
                'select_city' => 'Выберите город:',
                'select_departament' => 'Выберите отделение:',
                'enter_price' => 'Введите стоимость посылки:',
                'count' => 'Стоимось пересылки:',
                'departement_not_found' => 'В городе нет отделений.'
            ]
        ];
     
        return view('home', [
            'cities' => City::getRichList($lang),
            'url' => url('/'),
            'lang' => $lang,
            'lables' => $lables[$lang]
        ]);
    }

    public function serchDepartement(Request $request)
    {
        $cityName = $request->input('params')['cityName'];
        $lang = $request->input('params')['lang'];
        $departements = NovaPoshtaHelper::getWarehouses($cityName, $lang)
            ->map(function ($item) use ($lang) {
                switch ($lang) {
                    case 'UA': {
                            $name = $item["Description"];
                            break;
                        }
                    case 'RU': {
                            $name = $item["DescriptionRu"];
                            break;
                        }
                    default:
                        $name = $item["Description"];
                        break;
                }

                return [
                    'SiteKey' => $item['SiteKey'],
                    'name' => $name
                ];
            });
        return $departements;
    }
}
