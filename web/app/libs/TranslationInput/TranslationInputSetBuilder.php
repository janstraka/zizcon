<?php

namespace Libs\TranslationInput;

use Nette\InvalidArgumentException;


abstract class TranslationInputSetBuilder
{
    /** @var TranslationInputSetBuilder[]  */
    private static $translation_set_builders;

    public static function getSetFor($fieldset_identificator)
    {
        if(empty(self::$translation_set_builders)){
            self::$translation_set_builders = [new TranslationInputSetBuilderGeneric, new TranslationInputSetBuilderRewards];
        }

        foreach(self::$translation_set_builders as $set_builder){
            $fields = $set_builder->createSet($fieldset_identificator);
            if($fields){
                return $fields;
            }
        }
        
        throw new InvalidArgumentException('Unsupported field set identificator supplied ('. $fieldset_identificator .'), please use appropriate field set identificator.');
    }

    protected abstract function createSet($fieldset_identificator);
}