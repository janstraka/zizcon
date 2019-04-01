<?php
/**
 * Created by PhpStorm.
 * User: Stepan
 * Date: 17.03.2016
 * Time: 19:39
 */

namespace Libs\TranslationInput;


use Nette\Forms\Container;

class TranslationInputUpload extends TranslationInput
{
    public function __construct($name, $label = '')
    {
        parent::__construct($name, $label);
    }


    public function addToContainer(Container $container)
    {
        $container->addUpload($this->name, $this->label);
    }
}