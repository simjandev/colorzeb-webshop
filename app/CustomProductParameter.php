<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomProductParameter extends Model
{
    public static function getByProductId($productId) {
        $parameters = [];
        
        $unsortedParameters = self::where('product_id', $productId)->orderBy('index', 'ASC')->get();
        foreach ($unsortedParameters as $parameter) {
            $key = NULL;
            foreach ($parameters as $index => $sortedParameter) {
                if ($sortedParameter->name == $parameter->name) {
                    $key = $index;
                    break;
                }
            }

            if (!isset($key)) {
                $parameterObject = new \StdClass();
                $parameterObject->name = $parameter->name;
                $parameterObject->type = $parameter->type;
                $parameterObject->index = $parameter->index;
                $parameterObject->options = array();
                
                $key = count($parameters);
                
                $parameters[$key] = $parameterObject;
            }

            $item = new \StdClass();
            $item->value = $parameter->value;
            $item->checked = false;
            array_push($parameters[$key]->options, $item);
        }

        return $parameters;
    }

    public static function getListForFilter() {
        $parameters = [];
        
        $unsortedParameters = self::distinct('value')->select(['name', 'value'])->where('type', 'select')->get();
        foreach ($unsortedParameters as $parameter) {
            if (!isset($parameters[$parameter->name])) {
                $parameters[$parameter->name] = [];
            }

            $item = new \StdClass();
            $item->value = $parameter->value;
            $item->checked = false;
            
            array_push($parameters[$parameter->name], $item);
        }

        return $parameters;
    }
}
