<?php
/**
 * Created by PhpStorm.
 * User: Stepan
 * Date: 07.04.2016
 * Time: 14:15
 */

namespace Libs\TranslationInput;


class TranslationInputSetBuilderGeneric extends TranslationInputSetBuilder
{

    protected function createSet($fieldset_identificator)
    {
        switch ($fieldset_identificator) {
            case TranslationInput::PAGE_HOMEPAGE:
                return $this->createHomepageFields();
            case TranslationInput::PAGE_HOTEL:
                return $this->createHotelFields();
            case TranslationInput::VARIOUS_TRANSLATIONS:
                return $this->createVariousTranslationsFields();
            case TranslationInput::MOTTO:
                return $this->createMottoFields();
            case TranslationInput::CONTACT:
                return $this->createContactFields();

        }
        return null;
    }

    private function createHomepageFields(){
        return [
            new TranslationInputText('hp_title', 'Nadpis'),
            new TranslationInputTextArea('hp_intro_1', 'Tělo 1'),
            new TranslationInputText('hp_ico_lbl_location', 'Popisek ikony lokace'),
            new TranslationInputText('hp_ico_lbl_character', 'Popisek ikony charakter'),
            new TranslationInputText('hp_ico_lbl_kitchen', 'Popisek ikony kuchyně'),
            new TranslationInputText('hp_tourbooks', 'Průvodci'),
            new TranslationInputText('hp_closure', 'Závěr'),
        ];
    }

    private function createMottoFields(){
        return [
            new TranslationInputText('motto', 'Motto'),
        ];
    }

    private function createContactFields(){
        return [
            new TranslationInputText('contact_street', 'Ulice'),
            new TranslationInputText('contact_city', 'Město'),
            new TranslationInputText('contact_state', 'Stát'),
            new TranslationInputText('contact_phone', 'Telefon'),
            new TranslationInputText('contact_fax', 'Fax'),
            new TranslationInputText('contact_email', 'Email'),

        ];
    }

    private function createHotelFields(){
        return [
            new TranslationInputText('hotel_intro', 'Úvod'),
            new TranslationInputText('hotel_why_book', 'Proč rezervovat'),
            new TranslationInputText('hotel_equipment', 'Vybavení hotelu'),
            new TranslationInputText('hotel_contact', 'Kontakt'),
            new TranslationInputText('hotel_manager', 'Provozovatel'),
            new TranslationInputUpload('factsheet', 'Factsheet'),
        ];
    }

    private function createVariousTranslationsFields()
    {
        // fiksme jeste by slo eliminovat to new TranslationInputText, ze by se to treba bralo z arraye
        // update vlastne asi neslo, neco je totiz textarea :)

        return [
            //new TranslationInputText('var_form_login_title', 'Nadpis přihlašovacího formuláře'),

            // Contact form and sign up
            new TranslationInputText('have_you_got_question', 'Máte dotaz?'),
            new TranslationInputText('name', 'Jméno'),
            new TranslationInputText('surname', 'Příjmení'),
            new TranslationInputText('your_email', 'Váš e-mail'),
            new TranslationInputText('send_message', 'Odeslat zprávu'),
            new TranslationInputText('birth_date', 'Datum narození'),
            new TranslationInputText('city', 'Město'),
            new TranslationInputText('street', 'Ulice'),
            new TranslationInputText('zip', 'PSČ'),
            new TranslationInputText('password', 'Heslo'),
            new TranslationInputText('password_confirmation', 'Potvrzení hesla'),
            new TranslationInputText('join_charming_rewards', 'Připojit se k Charming Rewards'),
            new TranslationInputText('sign_in', 'Přihlásit se'),
            new TranslationInputText('field_required', 'Tato položka je povinná'),
            new TranslationInputText('passwords_dont_match', 'Hesla se neshodují'),

            // Online reservation
            new TranslationInputText('booking_hotel', 'Rezervace hotelu'),
            new TranslationInputText('any_hotel', 'Jakýkoliv hotel'),
            new TranslationInputText('arrival', 'Příjezd'),
            new TranslationInputText('departure', 'Odjezd'),
            new TranslationInputText('check_availability', 'Zjistit dostupnost'),




            // Hotel
            new TranslationInputText('share_this_hotel', 'Sdílet tento hotel'),
            new TranslationInputText('other_advantages', 'Další výhody'),
            new TranslationInputText('more_information', 'Více informací'),
            new TranslationInputText('your_promo_code', 'Váš promo kód'),
            new TranslationInputText('click_here_to_apply', 'Click here to apply'),


            // Ostatni
            new TranslationInputText('contact', 'Kontakt'),
            new TranslationInputText('please_select_the_hotel_you_are_interested_in', 'Prosím vyberte si hotel o který máte zájem'),
            new TranslationInputText('download_all_photos', 'Stáhnout všechny fotky'),


            // Polozky v menu - fiksme prelozit
            new TranslationInputText('home', 'Home'),
            new TranslationInputText('hotels_we_operate', 'Hotels we operate'),
            new TranslationInputText('charming_rewards', 'Charming rewards'),
                new TranslationInputText('login_join_charming_rewards', 'Login/Join Charming rewards'),
                new TranslationInputText('levels_and_benefits', 'Levels and benefits'),
                new TranslationInputText('membership', 'Membership'),
                new TranslationInputText('earning_points', 'Earning Points'),
                new TranslationInputText('rewards', 'Rewards'),
                new TranslationInputText('customer_service', 'Zákaznický servis'),
            new TranslationInputText('for_travel_agents', 'For travel agents'),
            new TranslationInputText('language', 'Jazyk'),

        ];
    }
}