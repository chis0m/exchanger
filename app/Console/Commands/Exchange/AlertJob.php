<?php

namespace App\Console\Commands\Exchange;

use App\Services\ThirdParty\Exchange\Adapter as ExchangeAdapter;
use Illuminate\Console\Command;
use App\Models\Configuration;
use App\Models\Currency;
use Exception;
use App\User;

class AlertJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert user when his exchange alert is met';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::havingThreshold();
        foreach ($users as $user) {
            try {
                $baseCurrencySymbol = Currency::find($user['base_currency_id'])->symbol;
                $latestRates = (new ExchangeAdapter())->getLatestExchangeRate($baseCurrencySymbol);
                // $latestRates = $this->getDummyRates();
                $thresholds = $user->thresholds;
                foreach ($thresholds as $threshold) {
                    try {
                        $targetCurrencySymbol = Currency::find($threshold['target_currency_id'])->symbol;
                        $rate = $latestRates[$targetCurrencySymbol];
                        $thresholdNumber = $threshold['threshold_number'];
                        switch ($threshold->condition) {
                            case 'greater_than':
                                if ($thresholdNumber > $rate) {
                                    $condition = 'greater than';
                                    $user->notify(new \App\Notifications\Mails\ExchageAlert(
                                        $baseCurrencySymbol,
                                        $targetCurrencySymbol,
                                        $condition,
                                        $thresholdNumber
                                    ));
                                }
                                break;
                            case 'less_than':
                                if ($thresholdNumber < $rate) {
                                    $condition = 'lesser than';
                                    $user->notify(new \App\Notifications\Mails\ExchageAlert(
                                        $baseCurrencySymbol,
                                        $targetCurrencySymbol,
                                        $condition,
                                        $thresholdNumber
                                    ));
                                }
                                break;
                            case 'equal_to':
                                if ($thresholdNumber == $rate) {
                                    $condition = 'equal to';
                                    $user->notify(new \App\Notifications\Mails\ExchageAlert(
                                        $baseCurrencySymbol,
                                        $targetCurrencySymbol,
                                        $condition,
                                        $thresholdNumber
                                    ));
                                }
                                break;
                        }
                    } catch (Exception $e) {
                        $message = $e->getMessage();
                        \Log::info("AlertJob Inner Loop Error: " . $message);
                    }
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
                \Log::info("AlertJob Outer Loop Error: " . $message);
            }
        }
        return 0;
    }

    public function getDummyRates()
    {
        return [
            'AED' => 4.490491,
            'AFN' => 94.429984,
            'ALL' => 123.759979,
            'AMD' => 639.111161,
            'ANG' => 2.199,
            'AOA' => 799.209734,
            'ARS' => 104.045583,
            'AUD' => 1.575386,
            'AWG' => 2.2005,
            'AZN' => 2.083103,
            'BAM' => 1.95583,
            'BBD' => 2.4735,
            'BDT' => 103.831183,
            'BGN' => 1.954706,
            'BHD' => 0.4619,
            'BIF' => 2377.639602,
            'BMD' => 1.2225,
            'BND' => 1.6224,
            'BOB' => 8.434599,
            'BRL' => 6.620399,
            'BSD' => 1.2251,
            'BTC' => 3.0888103E-5,
            'BTN' => 89.752685,
            'BWP' => 13.469798,
            'BYN' => 3.141699,
            'BYR' => 23960.99599,
            'BZD' => 2.4694,
            'CAD' => 1.55241,
            'CDF' => 2408.325039,
            'CHF' => 1.082591,
            'CLF' => 0.031668,
            'CLP' => 873.821354,
            'CNY' => 7.91618,
            'COP' => 4275.499285,
            'CRC' => 752.069874,
            'CUC' => 1.2225,
            'CUP' => 32.396245,
            'CVE' => 110.264982,
            'CZK' => 26.173905,
            'DJF' => 218.089964,
            'DKK' => 7.439682,
            'DOP' => 71.335988,
            'DZD' => 161.595973,
            'EGP' => 19.233697,
            'ERN' => 18.337935,
            'ETB' => 48.275492,
            'EUR' => 1,
            'FJD' => 2.462298,
            'FKP' => 0.901048,
            'GBP' => 0.901183,
            'GEL' => 4.046952,
            'GGP' => 0.901048,
            'GHS' => 7.178899,
            'GIP' => 0.901048,
            'GMD' => 63.20795,
            'GNF' => 12575.397896,
            'GTQ' => 9.546398,
            'GYD' => 256.449957,
            'HKD' => 9.488934,
            'HNL' => 29.521995,
            'HRK' => 7.574491,
            'HTG' => 89.566985,
            'HUF' => 359.611014,
            'IDR' => 17280.462483,
            'ILS' => 3.891132,
            'IMP' => 0.901048,
            'INR' => 89.705084,
            'IQD' => 1788.609701,
            'IRR' => 51473.354318,
            'ISK' => 156.749396,
            'JEP' => 0.901048,
            'JMD' => 174.891971,
            'JOD' => 0.866391,
            'JPY' => 127.076457,
            'KES' => 134.206978,
            'KGS' => 101.561987,
            'KHR' => 4978.699167,
            'KMF' => 491.938559,
            'KPW' => 1100.249828,
            'KRW' => 1336.20497,
            'KWD' => 0.371127,
            'KYD' => 1.0209,
            'KZT' => 513.779914,
            'LAK' => 11388.298094,
            'LBP' => 1852.29969,
            'LKR' => 230.314061,
            'LRD' => 204.219058,
            'LSL' => 18.716938,
            'LTL' => 3.609725,
            'LVL' => 0.739478,
            'LYD' => 5.429399,
            'MAD' => 10.806598,
            'MDL' => 20.967796,
            'MGA' => 4672.439218,
            'MKD' => 61.61499,
            'MMK' => 1626.286828,
            'MNT' => 3490.576124,
            'MOP' => 9.784098,
            'MRO' => 436.432217,
            'MUR' => 48.267992,
            'MVR' => 18.851409,
            'MWK' => 944.783842,
            'MXN' => 24.461427,
            'MYR' => 4.929735,
            'MZN' => 91.595845,
            'NAD' => 18.716933,
            'NGN' => 484.519919,
            'NIO' => 42.693993,
            'NOK' => 10.277263,
            'NPR' => 143.603976,
            'NZD' => 1.687487,
            'OMR' => 0.470626,
            'PAB' => 1.2251,
            'PEN' => 4.437199,
            'PGK' => 4.310799,
            'PHP' => 58.74899,
            'PKR' => 196.318267,
            'PLN' => 4.513164,
            'PYG' => 8401.598594,
            'QAR' => 4.451169,
            'RON' => 4.8724,
            'RSD' => 117.647315,
            'RUB' => 90.567191,
            'RWF' => 1214.329797,
            'SAR' => 4.586537,
            'SBD' => 9.82971,
            'SCR' => 26.524996,
            'SDG' => 67.543569,
            'SEK' => 10.078399,
            'SGD' => 1.620937,
            'SHP' => 0.901048,
            'SLL' => 12475.610826,
            'SOS' => 712.717795,
            'SRD' => 17.303309,
            'STD' => 25470.616182,
            'SVC' => 10.719998,
            'SYP' => 626.924816,
            'SZL' => 18.652397,
            'THB' => 36.834371,
            'TJS' => 13.876998,
            'TMT' => 4.278749,
            'TND' => 3.291585,
            'TOP' => 2.768046,
            'TRY' => 9.017408,
            'TTD' => 8.325999,
            'TWD' => 34.252045,
            'TZS' => 2840.949525,
            'UAH' => 34.635394,
            'UGX' => 4533.999241,
            'USD' => 1.2225,
            'UYU' => 51.801991,
            'UZS' => 12814.287856,
            'VEF' => 12.209721,
            'VND' => 28258.995271,
            'VUV' => 131.421287,
            'WST' => 3.094905,
            'XAF' => 655.95689,
            'XAG' => 0.048067,
            'XAU' => 0.000662,
            'XCD' => 3.303867,
            'XDR' => 0.8476,
            'XOF' => 655.95689,
            'XPF' => 119.86655,
            'YER' => 306.118347,
            'ZAR' => 18.708458,
            'ZMK' => 11003.969551,
            'ZMW' => 25.999196,
            'ZWL' => 393.645161,
        ];
    }
}
