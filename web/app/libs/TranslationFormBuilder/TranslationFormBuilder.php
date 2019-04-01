<?php
namespace Libs;


use Libs\TranslationInput\TranslationInput;
use Model\Languages;
use Model\Translations;
use Nette\Application\UI\Form;

class TranslationFormBuilder
{
    private $languages;
    private $translations;

    private $inputs;

    public function __construct(Translations $translations, Languages $languages)
    {
        $this->languages = $languages;
        $this->translations = $translations;
    }

    public function build(Form $form, $inputs_identificator)
    {
        $inputs = TranslationInput::getTranslationFields($inputs_identificator);
        $this->inputs = TranslationInput::getInputNames($inputs);

        $languages = $this->languages->findAll();
        foreach ($languages as $language) {
            $group = $form->addGroup($language->title);
            $group->setOption('id_lang', $language->id);

            $container = $form->addContainer($language->id);

            TranslationInput::addAllToContainer($inputs, $container);
        }


        return $form;
    }

    /**
     * @param Form $form
     * @param $entity_key
     */
    public function setDefaults(Form $form, $entity_key = null)
    {
        $defaults = $this->translations->findByTranslationKey($this->inputs, $entity_key);
        $form->setDefaults($defaults);
    }

}