<?php
/**
 * Function provide array contain animation css
 *
 * @package     Bloks_Stripe
 * @subpackage  Functions
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Get button as HTML by $data
 *
 * @param $buttonData full options of this button
 * @return string button output HTML
 */
if(!function_exists('blopeGetButtonOutput')) {
    function blopeGetButtonOutput($buttonData)
    {
        if(!$buttonData) {
            return '<p class="blope-alert blope-alert-error">'. __('This Donation Button is invalid. Please check the settings and shortcode attributes', 'blope') .'</p>';
        }

        $file = BLOPE_PATH . '/templates/buttons/' . trim($buttonData->button_style) . '/layout.php';
        if (file_exists($file)) {
            $options = get_option('blope_options');
            $currency = isset($options['currency'])?$options['currency']:'usd';
            $currency_symbol = blopeGetCurrencySymbol($currency);

            //redefine variables to make layout file easy to understand
            $amount = (int)$buttonData->button_amount / 100;
            $ID = 'blope_btn_' . $buttonData->button_id;
            $title = $buttonData->button_title;
            $desc = $buttonData->button_desc;
            $animate = $buttonData->button_animate;
            $template_url = BLOPE_URL . 'templates/buttons/' . trim($buttonData->button_style);
            $flexible = '';

            $attributes = ' data-id="'. $buttonData->button_id .'" data-custom="'. $buttonData->button_custom_amount .'" data-amount="'. $buttonData->button_amount .'"'
            . ' data-store_desc="'. $buttonData->button_store_desc .'" data-zip_code="'. $buttonData->enable_zip_code.'" data-billing="'. $buttonData->enable_billing_address .'"'
            . ' data-remember="'. $buttonData->enable_remember .'" data-bitcoin="'. $buttonData->enable_bitcoin .'" data-panel_label="'. $buttonData->button_panel_label .'"'
            . ' data-animate="'. $buttonData->button_animate .'" ';

            //start get content from layout file
            ob_start();
            //place the custom amount input if needed
            if ($buttonData->button_custom_amount) {
                $flexible = 'blope-donation-flexible';
                include BLOPE_PATH . '/templates/custom.amount.php';
            }
            include $file;

            $content = ob_get_clean();

            //support tpl variables replace
            $listVars = array('{id}', '{amount}', '{title}', '{desc}', '{animate}', '{currency}', '{flexible}', '{currency_symbol}', '{template_url}', '{attributes}');
            $content = str_replace($listVars, array($ID, $amount, $title, $desc, $animate, $currency, $flexible, $currency_symbol, $template_url, $attributes), $content);

        } else {
            $content = 'Button style does not exist';
        }

        return $content;

    }
}

/**
 * Get list available currencies of Stripe
 * @return array
 */
if(!function_exists('blopeGetAvailableCurrencies')) {
    function blopeGetAvailableCurrencies() {
        return array(
            'aed' => array(
                'code' => 'AED',
                'symbol' => 'DH',
                'name' => 'United Arab Emirates Dirham'
            ),
            'afn' => array(
                'code' => 'AFN',
                'symbol' => '؋',
                'name' => 'Afghan Afghani'
            ),
            'all' => array(
                'code' => 'ALL',
                'symbol' => 'L',
                'name' => 'Albanian Lek'
            ),
            'amd' => array(
                'code' => 'AMD',
                'symbol' => '֏',
                'name' => 'Armenian Dram'
            ),
            'ang' => array(
                'code' => 'ANG',
                'symbol' => 'ƒ',
                'name' => 'Netherlands Antillean Gulden'
            ),
            'aoa' => array(
                'code' => 'AOA',
                'symbol' => 'Kz',
                'name' => 'Angolan Kwanza'
            ),
            'ars' => array(
                'code' => 'ARS',
                'symbol' => '$',
                'name' => 'Argentine Peso'
            ),
            'aud' => array(
                'code' => 'AUD',
                'symbol' => '$',
                'name' => 'Australian Dollar'
            ),
            'awg' => array(
                'code' => 'AWG',
                'symbol' => 'ƒ',
                'name' => 'Aruban Florin'
            ),
            'azn' => array(
                'code' => 'AZN',
                'symbol' => 'm.',
                'name' => 'Azerbaijani Manat'
            ),
            'bam' => array(
                'code' => 'BAM',
                'symbol' => 'KM',
                'name' => 'Bosnia & Herzegovina Convertible Mark'
            ),
            'bbd' => array(
                'code' => 'BBD',
                'symbol' => 'Bds$',
                'name' => 'Barbadian Dollar'
            ),
            'bdt' => array(
                'code' => 'BDT',
                'symbol' => '৳',
                'name' => 'Bangladeshi Taka'
            ),
            'bgn' => array(
                'code' => 'BGN',
                'symbol' => 'лв',
                'name' => 'Bulgarian Lev'
            ),
            'bif' => array(
                'code' => 'BIF',
                'symbol' => 'FBu',
                'name' => 'Burundian Franc',
            ),
            'bmd' => array(
                'code' => 'BMD',
                'symbol' => 'BD$',
                'name' => 'Bermudian Dollar'
            ),
            'bnd' => array(
                'code' => 'BND',
                'symbol' => 'B$',
                'name' => 'Brunei Dollar'
            ),
            'bob' => array(
                'code' => 'BOB',
                'symbol' => 'Bs.',
                'name' => 'Bolivian Boliviano'
            ),
            'brl' => array(
                'code' => 'BRL',
                'symbol' => 'R$',
                'name' => 'Brazilian Real'
            ),
            'bsd' => array(
                'code' => 'BSD',
                'symbol' => 'B$',
                'name' => 'Bahamian Dollar'
            ),
            'bwp' => array(
                'code' => 'BWP',
                'symbol' => 'P',
                'name' => 'Botswana Pula'
            ),
            'bzd' => array(
                'code' => 'BZD',
                'symbol' => 'BZ$',
                'name' => 'Belize Dollar'
            ),
            'cad' => array(
                'code' => 'CAD',
                'symbol' => '$',
                'name' => 'Canadian Dollar'
            ),
            'cdf' => array(
                'code' => 'CDF',
                'symbol' => 'CF',
                'name' => 'Congolese Franc'
            ),
            'chf' => array(
                'code' => 'CHF',
                'symbol' => 'Fr',
                'name' => 'Swiss Franc'
            ),
            'clp' => array(
                'code' => 'CLP',
                'symbol' => 'CLP$',
                'name' => 'Chilean Peso'
            ),
            'cny' => array(
                'code' => 'CNY',
                'symbol' => '¥',
                'name' => 'Chinese Renminbi Yuan'
            ),
            'cop' => array(
                'code' => 'COP',
                'symbol' => 'COL$',
                'name' => 'Colombian Peso'
            ),
            'crc' => array(
                'code' => 'CRC',
                'symbol' => '₡',
                'name' => 'Costa Rican Colón'
            ),
            'cve' => array(
                'code' => 'CVE',
                'symbol' => 'Esc',
                'name' => 'Cape Verdean Escudo'
            ),
            'czk' => array(
                'code' => 'CZK',
                'symbol' => 'Kč',
                'name' => 'Czech Koruna'
            ),
            'djf' => array(
                'code' => 'DJF',
                'symbol' => 'Fr',
                'name' => 'Djiboutian Franc'
            ),
            'dkk' => array(
                'code' => 'DKK',
                'symbol' => 'kr',
                'name' => 'Danish Krone'
            ),
            'dop' => array(
                'code' => 'DOP',
                'symbol' => 'RD$',
                'name' => 'Dominican Peso'
            ),
            'dzd' => array(
                'code' => 'DZD',
                'symbol' => 'DA',
                'name' => 'Algerian Dinar'
            ),
            'egp' => array(
                'code' => 'EGP',
                'symbol' => 'L.E.',
                'name' => 'Egyptian Pound'
            ),
            'etb' => array(
                'code' => 'ETB',
                'symbol' => 'Br',
                'name' => 'Ethiopian Birr'
            ),
            'eur' => array(
                'code' => 'EUR',
                'symbol' => '€',
                'name' => 'Euro',

            ),
            'fjd' => array(
                'code' => 'FJD',
                'symbol' => 'FJ$',
                'name' => 'Fijian Dollar'
            ),
            'fkp' => array(
                'code' => 'FKP',
                'symbol' => 'FK£',
                'name' => 'Falkland Islands Pound'
            ),
            'gbp' => array(
                'code' => 'GBP',
                'symbol' => '£',
                'name' => 'British Pound'
            ),
            'gel' => array(
                'code' => 'GEL',
                'symbol' => 'ლ',
                'name' => 'Georgian Lari'
            ),
            'gip' => array(
                'code' => 'GIP',
                'symbol' => '£',
                'name' => 'Gibraltar Pound'
            ),
            'gmd' => array(
                'code' => 'GMD',
                'symbol' => 'D',
                'name' => 'Gambian Dalasi'
            ),
            'gnf' => array(
                'code' => 'GNF',
                'symbol' => 'FG',
                'name' => 'Guinean Franc'
            ),
            'gtq' => array(
                'code' => 'GTQ',
                'symbol' => 'Q',
                'name' => 'Guatemalan Quetzal'
            ),
            'gyd' => array(
                'code' => 'GYD',
                'symbol' => 'G$',
                'name' => 'Guyanese Dollar'
            ),
            'hkd' => array(
                'code' => 'HKD',
                'symbol' => 'HK$',
                'name' => 'Hong Kong Dollar'
            ),
            'hnl' => array(
                'code' => 'HNL',
                'symbol' => 'L',
                'name' => 'Honduran Lempira'
            ),
            'hrk' => array(
                'code' => 'HRK',
                'symbol' => 'kn',
                'name' => 'Croatian Kuna'
            ),
            'htg' => array(
                'code' => 'HTG',
                'symbol' => 'G',
                'name' => 'Haitian Gourde'
            ),
            'huf' => array(
                'code' => 'HUF',
                'symbol' => 'Ft',
                'name' => 'Hungarian Forint'
            ),
            'idr' => array(
                'code' => 'IDR',
                'symbol' => 'Rp',
                'name' => 'Indonesian Rupiah'
            ),
            'ils' => array(
                'code' => 'ILS',
                'symbol' => '₪',
                'name' => 'Israeli New Sheqel'
            ),
            'inr' => array(
                'code' => 'INR',
                'symbol' => '₹',
                'name' => 'Indian Rupee'
            ),
            'isk' => array(
                'code' => 'ISK',
                'symbol' => 'ikr',
                'name' => 'Icelandic Króna'
            ),
            'jmd' => array(
                'code' => 'JMD',
                'symbol' => 'J$',
                'name' => 'Jamaican Dollar'
            ),
            'jpy' => array(
                'code' => 'JPY',
                'symbol' => '¥',
                'name' => 'Japanese Yen'
            ),
            'kes' => array(
                'code' => 'KES',
                'symbol' => 'Ksh',
                'name' => 'Kenyan Shilling'
            ),
            'kgs' => array(
                'code' => 'KGS',
                'symbol' => 'COM',
                'name' => 'Kyrgyzstani Som'
            ),
            'khr' => array(
                'code' => 'KHR',
                'symbol' => '៛',
                'name' => 'Cambodian Riel'
            ),
            'kmf' => array(
                'code' => 'KMF',
                'symbol' => 'CF',
                'name' => 'Comorian Franc'
            ),
            'krw' => array(
                'code' => 'KRW',
                'symbol' => '₩',
                'name' => 'South Korean Won'
            ),
            'kyd' => array(
                'code' => 'KYD',
                'symbol' => 'CI$',
                'name' => 'Cayman Islands Dollar'
            ),
            'kzt' => array(
                'code' => 'KZT',
                'symbol' => '₸',
                'name' => 'Kazakhstani Tenge'
            ),
            'lak' => array(
                'code' => 'LAK',
                'symbol' => '₭',
                'name' => 'Lao Kip'
            ),
            'lbp' => array(
                'code' => 'LBP',
                'symbol' => 'LL',
                'name' => 'Lebanese Pound'
            ),
            'lkr' => array(
                'code' => 'LKR',
                'symbol' => 'SLRs',
                'name' => 'Sri Lankan Rupee'
            ),
            'lrd' => array(
                'code' => 'LRD',
                'symbol' => 'L$',
                'name' => 'Liberian Dollar'
            ),
            'lsl' => array(
                'code' => 'LSL',
                'symbol' => 'M',
                'name' => 'Lesotho Loti'
            ),
            'mad' => array(
                'code' => 'MAD',
                'symbol' => 'DH',
                'name' => 'Moroccan Dirham'
            ),
            'mdl' => array(
                'code' => 'MDL',
                'symbol' => 'MDL',
                'name' => 'Moldovan Leu'
            ),
            'mga' => array(
                'code' => 'MGA',
                'symbol' => 'Ar',
                'name' => 'Malagasy Ariary'
            ),
            'mkd' => array(
                'code' => 'MKD',
                'symbol' => 'ден',
                'name' => 'Macedonian Denar'
            ),
            'mnt' => array(
                'code' => 'MNT',
                'symbol' => '₮',
                'name' => 'Mongolian Tögrög'
            ),
            'mop' => array(
                'code' => 'MOP',
                'symbol' => 'MOP$',
                'name' => 'Macanese Pataca'
            ),
            'mro' => array(
                'code' => 'MRO',
                'symbol' => 'UM',
                'name' => 'Mauritanian Ouguiya'
            ),
            'mur' => array(
                'code' => 'MUR',
                'symbol' => 'Rs',
                'name' => 'Mauritian Rupee'
            ),
            'mvr' => array(
                'code' => 'MVR',
                'symbol' => 'Rf.',
                'name' => 'Maldivian Rufiyaa'
            ),
            'mwk' => array(
                'code' => 'MWK',
                'symbol' => 'MK',
                'name' => 'Malawian Kwacha'
            ),
            'mxn' => array(
                'code' => 'MXN',
                'symbol' => '$',
                'name' => 'Mexican Peso'
            ),
            'myr' => array(
                'code' => 'MYR',
                'symbol' => 'RM',
                'name' => 'Malaysian Ringgit'
            ),
            'mzn' => array(
                'code' => 'MZN',
                'symbol' => 'MT',
                'name' => 'Mozambican Metical'
            ),
            'nad' => array(
                'code' => 'NAD',
                'symbol' => 'N$',
                'name' => 'Namibian Dollar'
            ),
            'ngn' => array(
                'code' => 'NGN',
                'symbol' => '₦',
                'name' => 'Nigerian Naira'
            ),
            'nio' => array(
                'code' => 'NIO',
                'symbol' => 'C$',
                'name' => 'Nicaraguan Córdoba'
            ),
            'nok' => array(
                'code' => 'NOK',
                'symbol' => 'kr',
                'name' => 'Norwegian Krone'
            ),
            'npr' => array(
                'code' => 'NPR',
                'symbol' => 'NRs',
                'name' => 'Nepalese Rupee'
            ),
            'nzd' => array(
                'code' => 'NZD',
                'symbol' => 'NZ$',
                'name' => 'New Zealand Dollar'
            ),
            'pab' => array(
                'code' => 'PAB',
                'symbol' => 'B/.',
                'name' => 'Panamanian Balboa'
            ),
            'pen' => array(
                'code' => 'PEN',
                'symbol' => 'S/.',
                'name' => 'Peruvian Nuevo Sol'
            ),
            'pgk' => array(
                'code' => 'PGK',
                'symbol' => 'K',
                'name' => 'Papua New Guinean Kina'
            ),
            'php' => array(
                'code' => 'PHP',
                'symbol' => '₱',
                'name' => 'Philippine Peso'
            ),
            'pkr' => array(
                'code' => 'PKR',
                'symbol' => 'PKR',
                'name' => 'Pakistani Rupee'
            ),
            'pln' => array(
                'code' => 'PLN',
                'symbol' => 'zł',
                'name' => 'Polish Złoty'
            ),
            'pyg' => array(
                'code' => 'PYG',
                'symbol' => '₲',
                'name' => 'Paraguayan Guaraní'
            ),
            'qar' => array(
                'code' => 'QAR',
                'symbol' => 'QR',
                'name' => 'Qatari Riyal'
            ),
            'ron' => array(
                'code' => 'RON',
                'symbol' => 'RON',
                'name' => 'Romanian Leu'
            ),
            'rsd' => array(
                'code' => 'RSD',
                'symbol' => 'дин',
                'name' => 'Serbian Dinar'
            ),
            'rub' => array(
                'code' => 'RUB',
                'symbol' => 'руб',
                'name' => 'Russian Ruble'
            ),
            'rwf' => array(
                'code' => 'RWF',
                'symbol' => 'FRw',
                'name' => 'Rwandan Franc'
            ),
            'sar' => array(
                'code' => 'SAR',
                'symbol' => 'SR',
                'name' => 'Saudi Riyal'
            ),
            'sbd' => array(
                'code' => 'SBD',
                'symbol' => 'SI$',
                'name' => 'Solomon Islands Dollar'
            ),
            'scr' => array(
                'code' => 'SCR',
                'symbol' => 'SRe',
                'name' => 'Seychellois Rupee'
            ),
            'sek' => array(
                'code' => 'SEK',
                'symbol' => 'kr',
                'name' => 'Swedish Krona'
            ),
            'sgd' => array(
                'code' => 'SGD',
                'symbol' => 'S$',
                'name' => 'Singapore Dollar'
            ),
            'shp' => array(
                'code' => 'SHP',
                'symbol' => '£',
                'name' => 'Saint Helenian Pound'
            ),
            'sll' => array(
                'code' => 'SLL',
                'symbol' => 'Le',
                'name' => 'Sierra Leonean Leone'
            ),
            'sos' => array(
                'code' => 'SOS',
                'symbol' => 'Sh.So.',
                'name' => 'Somali Shilling'
            ),
            'std' => array(
                'code' => 'STD',
                'symbol' => 'Db',
                'name' => 'São Tomé and Príncipe Dobra'
            ),
            'srd' => array(
                'code' => 'SRD',
                'symbol' => 'SRD',
                'name' => 'Surinamese Dollar'
            ),
            'svc' => array(
                'code' => 'SVC',
                'symbol' => '₡',
                'name' => 'Salvadoran Colón'
            ),
            'szl' => array(
                'code' => 'SZL',
                'symbol' => 'E',
                'name' => 'Swazi Lilangeni'
            ),
            'thb' => array(
                'code' => 'THB',
                'symbol' => '฿',
                'name' => 'Thai Baht'
            ),
            'tjs' => array(
                'code' => 'TJS',
                'symbol' => 'TJS',
                'name' => 'Tajikistani Somoni'
            ),
            'top' => array(
                'code' => 'TOP',
                'symbol' => '$',
                'name' => 'Tongan Paʻanga'
            ),
            'try' => array(
                'code' => 'TRY',
                'symbol' => '₺',
                'name' => 'Turkish Lira'
            ),
            'ttd' => array(
                'code' => 'TTD',
                'symbol' => 'TT$',
                'name' => 'Trinidad and Tobago Dollar'
            ),
            'twd' => array(
                'code' => 'TWD',
                'symbol' => 'NT$',
                'name' => 'New Taiwan Dollar'
            ),
            'tzs' => array(
                'code' => 'TZS',
                'symbol' => 'TSh',
                'name' => 'Tanzanian Shilling'
            ),
            'uah' => array(
                'code' => 'UAH',
                'symbol' => '₴',
                'name' => 'Ukrainian Hryvnia'
            ),
            'ugx' => array(
                'code' => 'UGX',
                'symbol' => 'USh',
                'name' => 'Ugandan Shilling'
            ),
            'usd' => array(
                'code' => 'USD',
                'symbol' => '$',
                'name' => 'United States Dollar'
            ),
            'uyu' => array(
                'code' => 'UYU',
                'symbol' => '$U',
                'name' => 'Uruguayan Peso'
            ),
            'uzs' => array(
                'code' => 'UZS',
                'symbol' => 'UZS',
                'name' => 'Uzbekistani Som'
            ),
            'vnd' => array(
                'code' => 'VND',
                'symbol' => '₫',
                'name' => 'Vietnamese Đồng'
            ),
            'vuv' => array(
                'code' => 'VUV',
                'symbol' => 'VT',
                'name' => 'Vanuatu Vatu'
            ),
            'wst' => array(
                'code' => 'WST',
                'symbol' => 'WS$',
                'name' => 'Samoan Tala'
            ),
            'xaf' => array(
                'code' => 'XAF',
                'symbol' => 'FCFA',
                'name' => 'Central African Cfa Franc'
            ),
            'xcd' => array(
                'code' => 'XCD',
                'symbol' => 'EC$',
                'name' => 'East Caribbean Dollar'
            ),
            'xof' => array(
                'code' => 'XOF',
                'symbol' => 'CFA',
                'name' => 'West African Cfa Franc'
            ),
            'xpf' => array(
                'code' => 'XPF',
                'symbol' => 'F',
                'name' => 'Cfp Franc'
            ),
            'yer' => array(
                'code' => 'YER',
                'symbol' => '﷼',
                'name' => 'Yemeni Rial'
            ),
            'zar' => array(
                'code' => 'ZAR',
                'symbol' => 'R',
                'name' => 'South African Rand'
            ),
            'zmw' => array(
                'code' => 'ZMW',
                'symbol' => 'ZK',
                'name' => 'Zambian Kwacha'
            )
        );
    }
}


/**
 * Get currency symbol
 *
 * @param $currency
 *
 * @return null|string
 */
if(!function_exists('blopeGetCurrencySymbol')) {
    function blopeGetCurrencySymbol($currency) {
        if(!isset($currency))
            return null;

        $available = blopeGetAvailableCurrencies();

        if (isset($available) && array_key_exists($currency, $available)) {
            $symbol = $available[$currency]['symbol'];
        } else {
            $symbol = strtoupper($currency);
        }

        return $symbol;
    }
}

