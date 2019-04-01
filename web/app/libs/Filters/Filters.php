<?php



class Filters
{
    public static function common($filter, $value)
    {
        if (method_exists(__CLASS__, $filter)) {
            $args = func_get_args();
            array_shift($args);
            return call_user_func_array(array(__CLASS__, $filter), $args);
        }
    }

    public static function shortify($s, $len = 10)
    {
        return mb_substr($s, 0, $len);
    }

    public static function price($s, $len = 10)
    {
        if($s == ''){
            $s = 0;
        }
        if($s == -1){
            $s = '';
        }

        $price = number_format($s, 0, ',', ' ') . ',- Kč'; // fiksme vzit z DB

        return $price;
    }

}



