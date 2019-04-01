<?php
/**
 * Created by PhpStorm.
 * User: Stepan
 * Date: 07.04.2016
 * Time: 14:15
 */

namespace Libs\TranslationInput;

use Entity\Reward;

class TranslationInputSetBuilderRewards extends TranslationInputSetBuilder
{

    const TEXT_TITLE = 'Hlavní nadpis';

    const TEXT_TEXT = 'Text';

    const TEXT_SUBTITLE = '. podnadpis';

    const TEXT_DOT_TEXT = '. text';

    protected function createSet($fieldset_identificator)
    {
        switch ($fieldset_identificator) {
            case TranslationInput::PAGE_REWARD_CATEGORIES:
                return $this->createRewardCategoriesFields();
            case TranslationInput::PAGE_SIGN_IN_UP:
                return $this->createSignInUpFields();
            case TranslationInput::FORM_JOIN_NOW:
                return $this->createFormJoinNowFields();
            case TranslationInput::PAGE_LEVELS_AND_BENEFITS:
                return $this->createLevelsAndBenefitsFields();
            case TranslationInput::PAGE_MEMBERSHIP:
                return $this->createMembershipFields();
            case TranslationInput::PAGE_EARNING_POINTS:
                return $this->createEarningPointsFields();
            case TranslationInput::PAGE_REWARDS:
                return $this->createRewardsFields();
            case TranslationInput::PAGE_CUSTOMER_SERVICE:
                return $this->createCustomerServiceFields();


        }
        return null;
    }

    private function createRewardCategoriesFields()
    {
        return [
            new TranslationInputText(Reward::CATEGORY_CAR_RENT, 'Půjčení vozidla'),
            new TranslationInputText(Reward::CATEGORY_FUN_AND_CULTURE, 'Zábava a kultura'),
            new TranslationInputText(Reward::CATEGORY_FREE_NIGHT, 'Noc zdarma'),
            new TranslationInputText(Reward::CATEGORY_GIFTS, 'Dárky'),
            new TranslationInputText(Reward::CATEGORY_CARE, 'Péče'),
            new TranslationInputText(Reward::CATEGORY_ROUND_TRIPS, 'Výlety'),
            new TranslationInputText(Reward::CATEGORY_WEEKEND_REWARDS, 'Víkendové odměny'),
        ];
    }

    private function createSignInUpFields()
    {
        $return = [
            new TranslationInputText('rew_siu_title', self::TEXT_TITLE),
        ];

        for ($i = 1; $i <= 3; $i++) {
            $return[] = new TranslationInputText('rew_siu_subtitle_' . $i, $i . self::TEXT_SUBTITLE);
            $return[] = new TranslationInputTextArea('rew_siu_text_' . $i, $i . self::TEXT_DOT_TEXT);
        }

        return $return;
    }

    private function createFormJoinNowFields()
    {
        $return = [];
        $return[] = new TranslationInputText('rew_fjn_title', self::TEXT_TITLE);
        $return[] = new TranslationInputTextArea('rew_fjn_text_', self::TEXT_TEXT);
        return $return;
    }

    private function createLevelsAndBenefitsFields()
    {
        $return = [];
        $return[] = new TranslationInputText('rew_lab_title', self::TEXT_TITLE);
        $return[] = new TranslationInputTextArea('rew_lab_text', self::TEXT_TEXT);

        for ($i = 1; $i <= 6; $i++) { // kdyby toho bylo v budoucnu vic
            $return[] = new TranslationInputText('rew_lab_subtitle_' . $i, $i . self::TEXT_SUBTITLE);
            $return[] = new TranslationInputTextArea('rew_lab_text_' . $i, $i . self::TEXT_DOT_TEXT);
        }

        return $return;
    }

    private function createMembershipFields()
    {
        $return = [];
        $return[] = new TranslationInputText('rew_mem_title', self::TEXT_TITLE);
        $return[] = new TranslationInputTextArea('rew_mem_text', self::TEXT_TEXT);

        for ($i = 1; $i <= 4; $i++) {
            $return[] = new TranslationInputText('rew_mem_subtitle_' . $i, $i . self::TEXT_SUBTITLE);
            $return[] = new TranslationInputTextArea('rew_mem_text_' . $i, $i . self::TEXT_DOT_TEXT);
        }

        return $return;
    }

    private function createEarningPointsFields()
    {
        $return = [];
        $return[] = new TranslationInputText('rew_m_title', self::TEXT_TITLE);
        $return[] = new TranslationInputTextArea('rew_m_text', self::TEXT_TEXT);

        for ($i = 1; $i <= 2; $i++) {
            $return[] = new TranslationInputText('rew_m_subtitle_' . $i, $i . self::TEXT_SUBTITLE);
            $return[] = new TranslationInputTextArea('rew_m_text_' . $i, $i . self::TEXT_DOT_TEXT);
        }

        return $return;
    }


    private function createRewardsFields()
    {
        $return = [];
        $return[] = new TranslationInputText('rew_rew_title', self::TEXT_TITLE);
        $return[] = new TranslationInputTextArea('rew_rew_text', self::TEXT_TEXT);

        for ($i = 1; $i <= 7; $i++) {
            $return[] = new TranslationInputText('rew_rew_subtitle_' . $i, $i . self::TEXT_SUBTITLE);
            $return[] = new TranslationInputTextArea('rew_rew_text_' . $i, $i . self::TEXT_DOT_TEXT);
        }

        return $return;
    }

    private function createCustomerServiceFields()
    {
        $return = [];
        $return[] = new TranslationInputText('rew_cus_title', self::TEXT_TITLE);
        $return[] = new TranslationInputTextArea('rew_cus_text', self::TEXT_TEXT);

        for ($i = 1; $i <= 7; $i++) {
            $return[] = new TranslationInputText('rew_cus_subtitle_' . $i, $i . self::TEXT_SUBTITLE);
            $return[] = new TranslationInputTextArea('rew_cus_text_' . $i, $i . self::TEXT_DOT_TEXT);
        }


        return $return;
    }

    private function createCustomerServiecFields()
    {
        $return = [
            new TranslationInputText('rew_css_title', 'Hlavní nadpis'),
            new TranslationInputTextArea('rew_css_text', 'Text'),
        ];
        return $return;
    }
}