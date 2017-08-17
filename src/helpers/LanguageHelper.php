<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\helpers;

use Yii;

/**
 * Languages helper.
 */
class LanguageHelper extends \yii\helpers\FileHelper
{
    /**
     * @var bool
     */
    protected static $registeredJs = false;

    /**
     * @param array $keys
     * @param View $view
     */
    public static function sendToJs($keys = [], View $view)
    {
        $string = '';
        if (!static::$registeredJs) {
            $view->registerJs('var Lang = {};', View::POS_HEAD);
            static::$registeredJs = true;
        }
        foreach ($keys as $key => $value) {
            $string .= "Lang.{$key} = '{$value}';" . PHP_EOL;
        }
        $view->registerJs($string, View::POS_HEAD);
    }

    /**
     * @param $code
     * @return string
     */
    public static function getIconUrl($code)
    {
        if (trim($code) !== '') {
            return FileHelper::getAssetUrl('kartik\icons\FlagIconAsset') . '/flags/4x3/' . strtolower($code) . '.svg';
        }
    }

    /**
     * @return array
     */
    public static function getCountries()
    {
        return [
            ''   => '',
            'AX' =>'AALAND ISLANDS',
            'AF' =>'AFGHANISTAN',
            'AL' =>'ALBANIA',
            'DZ' =>'ALGERIA',
            'AS' =>'AMERICAN SAMOA',
            'AD' =>'ANDORRA',
            'AO' =>'ANGOLA',
            'AI' =>'ANGUILLA',
            'AQ' =>'ANTARCTICA',
            'AG' =>'ANTIGUA AND BARBUDA',
            'AR' =>'ARGENTINA',
            'AM' =>'ARMENIA',
            'AW' =>'ARUBA',
            'AU' =>'AUSTRALIA',
            'AT' =>'AUSTRIA',
            'AZ' =>'AZERBAIJAN',
            'BS' =>'BAHAMAS',
            'BH' =>'BAHRAIN',
            'BD' =>'BANGLADESH',
            'BB' =>'BARBADOS',
            'BY' =>'BELARUS',
            'BE' =>'BELGIUM',
            'BZ' =>'BELIZE',
            'BJ' =>'BENIN',
            'BM' =>'BERMUDA',
            'BT' =>'BHUTAN',
            'BO' =>'BOLIVIA',
            'BA' =>'BOSNIA AND HERZEGOWINA',
            'BW' =>'BOTSWANA',
            'BV' =>'BOUVET ISLAND',
            'BR' =>'BRAZIL',
            'IO' =>'BRITISH INDIAN OCEAN TERRITORY',
            'BN' =>'BRUNEI DARUSSALAM',
            'BG' =>'BULGARIA',
            'BF' =>'BURKINA FASO',
            'BI' =>'BURUNDI',
            'KH' =>'CAMBODIA',
            'CM' =>'CAMEROON',
            'CA' =>'CANADA',
            'CV' =>'CAPE VERDE',
            'KY' =>'CAYMAN ISLANDS',
            'CF' =>'CENTRAL AFRICAN REPUBLIC',
            'TD' =>'CHAD',
            'CL' =>'CHILE',
            'CN' =>'CHINA',
            'CX' =>'CHRISTMAS ISLAND',
            'CO' =>'COLOMBIA',
            'KM' =>'COMOROS',
            'CK' =>'COOK ISLANDS',
            'CR' =>'COSTA RICA',
            'CI' =>'COTE D\'IVOIRE',
            'CU' =>'CUBA',
            'CY' =>'CYPRUS',
            'CZ' =>'CZECH REPUBLIC',
            'DK' =>'DENMARK',
            'DJ' =>'DJIBOUTI',
            'DM' =>'DOMINICA',
            'DO' =>'DOMINICAN REPUBLIC',
            'EC' =>'ECUADOR',
            'EG' =>'EGYPT',
            'SV' =>'EL SALVADOR',
            'GQ' =>'EQUATORIAL GUINEA',
            'ER' =>'ERITREA',
            'EE' =>'ESTONIA',
            'ET' =>'ETHIOPIA',
            'FO' =>'FAROE ISLANDS',
            'FJ' =>'FIJI',
            'FI' =>'FINLAND',
            'FR' =>'FRANCE',
            'GF' =>'FRENCH GUIANA',
            'PF' =>'FRENCH POLYNESIA',
            'TF' =>'FRENCH SOUTHERN TERRITORIES',
            'GA' =>'GABON',
            'GM' =>'GAMBIA',
            'GE' =>'GEORGIA',
            'DE' =>'GERMANY',
            'GH' =>'GHANA',
            'GI' =>'GIBRALTAR',
            'GR' =>'GREECE',
            'GL' =>'GREENLAND',
            'GD' =>'GRENADA',
            'GP' =>'GUADELOUPE',
            'GU' =>'GUAM',
            'GT' =>'GUATEMALA',
            'GN' =>'GUINEA',
            'GW' =>'GUINEA-BISSAU',
            'GY' =>'GUYANA',
            'HT' =>'HAITI',
            'HM' =>'HEARD AND MC DONALD ISLANDS',
            'HN' =>'HONDURAS',
            'HK' =>'HONG KONG',
            'HU' =>'HUNGARY',
            'IS' =>'ICELAND',
            'IN' =>'INDIA',
            'ID' =>'INDONESIA',
            'IQ' =>'IRAQ',
            'IE' =>'IRELAND',
            'IL' =>'ISRAEL',
            'IT' =>'ITALY',
            'JM' =>'JAMAICA',
            'JP' =>'JAPAN',
            'JO' =>'JORDAN',
            'KZ' =>'KAZAKHSTAN',
            'KE' =>'KENYA',
            'KI' =>'KIRIBATI',
            'KW' =>'KUWAIT',
            'KG' =>'KYRGYZSTAN',
            'LA' =>'LAO PEOPLE\'S DEMOCRATIC REPUBLIC',
            'LV' =>'LATVIA',
            'LB' =>'LEBANON',
            'LS' =>'LESOTHO',
            'LR' =>'LIBERIA',
            'LY' =>'LIBYAN ARAB JAMAHIRIYA',
            'LI' =>'LIECHTENSTEIN',
            'LT' =>'LITHUANIA',
            'LU' =>'LUXEMBOURG',
            'MO' =>'MACAU',
            'MG' =>'MADAGASCAR',
            'MW' =>'MALAWI',
            'MY' =>'MALAYSIA',
            'MV' =>'MALDIVES',
            'ML' =>'MALI',
            'MT' =>'MALTA',
            'MH' =>'MARSHALL ISLANDS',
            'MQ' =>'MARTINIQUE',
            'MR' =>'MAURITANIA',
            'MU' =>'MAURITIUS',
            'YT' =>'MAYOTTE',
            'MX' =>'MEXICO',
            'MC' =>'MONACO',
            'MN' =>'MONGOLIA',
            'MS' =>'MONTSERRAT',
            'MA' =>'MOROCCO',
            'MZ' =>'MOZAMBIQUE',
            'MM' =>'MYANMAR',
            'NA' =>'NAMIBIA',
            'NR' =>'NAURU',
            'NP' =>'NEPAL',
            'NL' =>'NETHERLANDS',
            // 'AN' =>'NETHERLANDS ANTILLES',
            'NC' =>'NEW CALEDONIA',
            'NZ' =>'NEW ZEALAND',
            'NI' =>'NICARAGUA',
            'NE' =>'NIGER',
            'NG' =>'NIGERIA',
            'NU' =>'NIUE',
            'NF' =>'NORFOLK ISLAND',
            'MP' =>'NORTHERN MARIANA ISLANDS',
            'NO' =>'NORWAY',
            'OM' =>'OMAN',
            'PK' =>'PAKISTAN',
            'PW' =>'PALAU',
            'PA' =>'PANAMA',
            'PG' =>'PAPUA NEW GUINEA',
            'PY' =>'PARAGUAY',
            'PE' =>'PERU',
            'PH' =>'PHILIPPINES',
            'PN' =>'PITCAIRN',
            'PL' =>'POLAND',
            'PT' =>'PORTUGAL',
            'PR' =>'PUERTO RICO',
            'QA' =>'QATAR',
            'RE' =>'REUNION',
            'RO' =>'ROMANIA',
            'RU' =>'RUSSIAN FEDERATION',
            'RW' =>'RWANDA',
            'SH' =>'SAINT HELENA',
            'KN' =>'SAINT KITTS AND NEVIS',
            'LC' =>'SAINT LUCIA',
            'PM' =>'SAINT PIERRE AND MIQUELON',
            'VC' =>'SAINT VINCENT AND THE GRENADINES',
            'WS' =>'SAMOA',
            'SM' =>'SAN MARINO',
            'ST' =>'SAO TOME AND PRINCIPE',
            'SA' =>'SAUDI ARABIA',
            'SN' =>'SENEGAL',
            //'CS' =>'SERBIA AND MONTENEGRO',
            'SC' =>'SEYCHELLES',
            'SL' =>'SIERRA LEONE',
            'SG' =>'SINGAPORE',
            'SK' =>'SLOVAKIA',
            'SI' =>'SLOVENIA',
            'SB' =>'SOLOMON ISLANDS',
            'SO' =>'SOMALIA',
            'ZA' =>'SOUTH AFRICA',
            'GS' =>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
            'ES' =>'SPAIN',
            'LK' =>'SRI LANKA',
            'SD' =>'SUDAN',
            'SR' =>'SURINAME',
            'SJ' =>'SVALBARD AND JAN MAYEN ISLANDS',
            'SZ' =>'SWAZILAND',
            'SE' =>'SWEDEN',
            'CH' =>'SWITZERLAND',
            'SY' =>'SYRIAN ARAB REPUBLIC',
            'TW' =>'TAIWAN',
            'TJ' =>'TAJIKISTAN',
            'TH' =>'THAILAND',
            'TL' =>'TIMOR-LESTE',
            'TG' =>'TOGO',
            'TK' =>'TOKELAU',
            'TO' =>'TONGA',
            'TT' =>'TRINIDAD AND TOBAGO',
            'TN' =>'TUNISIA',
            'TR' =>'TURKEY',
            'TM' =>'TURKMENISTAN',
            'TC' =>'TURKS AND CAICOS ISLANDS',
            'TV' =>'TUVALU',
            'UG' =>'UGANDA',
            'UA' =>'UKRAINE',
            'AE' =>'UNITED ARAB EMIRATES',
            'GB' =>'UNITED KINGDOM',
            'US' =>'UNITED STATES',
            'UM' =>'UNITED STATES MINOR OUTLYING ISLANDS',
            'UY' =>'URUGUAY',
            'UZ' =>'UZBEKISTAN',
            'VU' =>'VANUATU',
            'VE' =>'VENEZUELA',
            'VN' =>'VIET NAM',
            'WF' =>'WALLIS AND FUTUNA ISLANDS',
            'EH' =>'WESTERN SAHARA',
            'YE' =>'YEMEN',
            'ZM' =>'ZAMBIA',
            'ZW' =>'ZIMBABWE',
        ];
    }
}