<?php

namespace Libs\TranslationInput;

use Nette\Forms\Container;

abstract class TranslationInput
{

    // find other in TranslationInputSetBuilderGeneric

    const
        PAGE_HOMEPAGE = 'homepage',
        PAGE_HOTEL = 'hotel',
        VARIOUS_TRANSLATIONS = 'various',
        MOTTO = 'motto',
        CONTACT = 'contact';


    const PAGE_REWARD_CATEGORIES = 'rewardCategories';
    const PAGE_SIGN_IN_UP = 'signInUp'; // fiksme mozna prejmenovat na loginJoinCharmingRewards
    const FORM_JOIN_NOW = 'joinNow';
    const PAGE_LEVELS_AND_BENEFITS = 'levelsAndBenefits';
    const PAGE_MEMBERSHIP = 'membership';
    const PAGE_EARNING_POINTS = 'earningPoints';
    const PAGE_REWARDS = 'rewards';
    const PAGE_CUSTOMER_SERVICE = 'customerService';

    /**
     * @param TranslationInput[] $inputs
     * @param Container $container
     */
    public static function addAllToContainer($inputs, $container){
        foreach($inputs as $input){
            $input->addToContainer($container);
        }
    }

    public static function getTranslationFields($page, $names_only = false){
        $fields = TranslationInputSetBuilder::getSetFor($page);
        if($names_only){
            return self::getInputNames($fields);
        }
        return $fields;
    }


    /**
     * @param TranslationInput[] $inputs
     */
    public static function getInputNames($inputs){
        $names = [];
        foreach($inputs as $input){
            $names[] = $input->getName();
        }
        return $names;
    }

    protected
        $name,
        $label;

    /**
     * TranslationInput constructor.
     * @param String $label
     * @param int $type
     * @param $name
     */
    public function __construct($name, $label='')
    {
        $this->name = $name;
        $this->label = $label;
    }

    public abstract function addToContainer(Container $container);


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLabel()
    {
        return $this->label;
    }


    public function setLabel($label)
    {
        $this->label = $label;
    }




}