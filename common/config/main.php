<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'container' => [

    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
	    'formatter' => [
	                'dateFormat' => 'dd-MM-yyyy H:i:s',
	                'decimalSeparator' => ',',
	                'thousandSeparator' => ' ',
	                'currencyCode' => 'RUB',
	           ],
    ],
];
