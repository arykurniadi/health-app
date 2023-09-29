<?php 

namespace App\Presenters;

abstract class AbstractPresenter 
{
    public function get()
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        $result = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $result[$propertyName] = $this->$propertyName;
        }

        return $result;
    }
} 