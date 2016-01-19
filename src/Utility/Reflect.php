<?php 

namespace Helmut\Forms\Utility;

use ReflectionClass;
use ReflectionMethod;
use ReflectionException;

class Reflect {
	
    public static function getFilename($class) 
    {
        try {
           
            $reflector = new ReflectionClass($class);

            return $reflector->getFileName();

        } catch (ReflectionException $ex) {

        }
    }

    public static function getDirectory($class) 
    {
        $filename = static::getFilename($class);

        if ( ! is_null($filename)) {
            return dirname($filename);
        }
    }    

    public static function getNamespace($class) 
    {
        try {

            $reflector = new ReflectionClass($class);

            if ($reflector->inNamespace()) {
                return $reflector->getNamespaceName();
            }

        } catch (ReflectionException $ex) {

        }            
    }

    public static function getParameters($class, $method)
    {
        $params = [];

        try {

            $method = new ReflectionMethod($class, $method);

            foreach($method->getParameters() as $param) {
                $params[] = $param->getName();
            }

        } catch (ReflectionException $ex) {

        }

        return $params;
    }

}
