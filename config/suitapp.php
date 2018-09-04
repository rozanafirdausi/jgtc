<?php

return [
	'api' => [
		'google_map' => env('GOOGLE_MAP_API'),
		'facebook_app' => env('FACEBOOK_APP_ID')
	],

    'images' => [

        'imageWithThumbnail' => true,

        'imageDestinationPath' => 'public/files', // base_path based

        'imageUseAbsolutePath' => false,

        'imageFileNameOnly' => true,

        'imageBasePath' => 'public', // based_path based

        'imageDirectory' => '',

        'imageMaxHeight' => 1800, // based on retina display

        'imageMaxWidth' => 2880, // based on retina display
    ],

    'thumbnailer' => [

        // 'thumb' => '_thumb_',

        // 'size' => '300x300',
    ],

    'uploader' => [

        // 'override' => false,

        // 'modelOverride' => true,

        // 'baseFolder' => 'public/uploads',

        // 'folder' => '',

    ],

    'notifications' => [
        'namespace' => 'App\\SuitEvent\\Notifications\\',
        'allowEditSettings' => [
                                    'CommissionApplication',
                                    'MessageNewInbox',
                                    'OrderChangeStatus',
                                    'OrderNewOrder',
                                    'VoucherApplication',
                                    'WithdrawApproved',
                                ],
    ],
];