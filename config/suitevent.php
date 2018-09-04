<?php

return [

    'base_config' => [
        "pageId" => [
            'A' => [
                'label' => 'Home',
                'route' => 'backend.home.index',
                'icon' => 'fa-dashboard',
                'roles' => ['admin'],
                'submenu' => [
                    'A' => [
                        'label' => 'Dashboard',
                        'route' => 'backend.home.index',
                        'icon' => 'fa-dashboard',
                        'roles' => ['admin'],
                    ],
                ]
            ],
            'B' => [
                'label' => 'Site',
                'route' => '',
                'icon' => 'fa-home',
                'roles' => ['admin'],
                'submenu' => [
                    'B0' => [
                       'label' => 'Menus',
                       'route' => 'backend.menus.index',
                       'roles' => ['admin'],
                    ],
                    'B1' => [
                        'label' => 'Content Type & Category',
                        'route' => 'backend.contenttype.index',
                        'roles' => ['admin'],
                    ],
                    'B2' => [
                        'label' => 'Content',
                        'route' => 'backend.content.index',
                        'roles' => ['admin'],
                    ],
                    'B3' => [
                        'label' => 'FAQ',
                        'route' => 'backend.faq.index',
                        'roles' => ['admin'],
                    ],
                    'B4' => [
                        'label' => 'Banner',
                        'route' => 'backend.bannerimages.index',
                        'roles' => ['admin'],
                    ],
                    'B5' => [
                        'label' => 'Ads',
                        'route' => 'backend.advertisements.index',
                        'roles' => ['admin'],
                    ],
                    'B6' => [
                        'label' => 'Contact Form',
                        'route' => 'backend.contactmessage.index',
                        'roles' => ['admin'],
                    ],
                    'B7' => [
                        'label' => 'Setting',
                        'route' => 'backend.settings.view',
                        'roles' => ['admin'],
                    ],
                ]
            ],
            'C' => [
                'label' => 'User',
                'route' => '',
                'icon' => 'fa-user',
                'roles' => ['admin'],
                'submenu' => [
                    'C1' => [
                        'label' => 'User Management',
                        'route' => 'backend.user.index',
                        'roles' => ['admin'],
                    ]
                ]
            ],
            'D' => [
                'label' => 'Product Supply',
                'route' => '',
                'icon' => 'fa-share',
                'roles' => ['admin'],
                'submenu' => [
                    'D1' => [
                        'label' => 'Inbound Logistics',
                        'route' => 'backend.productsupply.index',
                        'roles' => ['admin'],
                    ],
                    'D2' => [
                        'label' => 'Suppliers',
                        'route' => 'backend.supplier.index',
                        'roles' => ['admin'],
                    ],
                    'D3' => [
                        'label' => 'Warehouse',
                        'route' => 'backend.warehouses.index',
                        'roles' => ['admin'],
                    ],
                    'D4' => [
                        'label' => 'Product Stock Type',
                        'route' => 'backend.stocktypes.index',
                        'roles' => ['admin'],
                    ],
                    'D5' => [
                        'label' => 'Product Stock Summary',
                        'route' => 'backend.stocksummaries.index',
                        'roles' => ['admin'],
                    ]
                ]
            ],
            'E' => [
                'label' => 'Product',
                'route' => '',
                'icon' => 'fa-suitcase',
                'roles' => ['admin'],
                'submenu' => [
                    'E1' => [
                        'label' => 'Product Items',
                        'route' => 'backend.product.index',
                        'roles' => ['admin'],
                    ],
                    'E2' => [
                        'label' => 'Categories',
                        'route' => 'backend.productcategory.index',
                        'roles' => ['admin'],
                    ],
                    'E3' => [
                        'label' => 'Brands',
                        'route' => 'backend.productbrand.index',
                        'roles' => ['admin'],
                    ],
                    'E4' => [
                        'label' => 'Wishlist',
                        'route' => 'backend.wishlists.index',
                        'roles' => ['admin'],
                    ]
                ]
            ],
            'F' => [
                'label' => 'Transaction',
                'route' => '',
                'icon' => 'fa-shopping-cart',
                'roles' => ['admin'],
                'submenu' => [
                    'F1' => [
                        'label' => 'Product Order',
                        'route' => 'backend.order.index',
                        'roles' => ['admin'],
                    ],
                    'F2' => [
                        'label' => 'User Deposit',
                        'route' => 'backend.escrow.index',
                        'roles' => ['admin'],
                    ]
                ]
            ],
            'G' => [
                'label' => 'Payment',
                'route' => '',
                'icon' => 'fa-money',
                'roles' => ['admin'],
                'submenu' => [
                    'G1' => [
                        'label' => 'Payment Method',
                        'route' => 'backend.paymentmethod.index',
                        'roles' => ['admin'],
                    ],
                    'G2' => [
                        'label' => 'Bank Transfer Payment Confirmation',
                        'route' => 'backend.paymentconfirmation.index',
                        'roles' => ['admin'],
                    ],
                    'G3' => [
                        'label' => 'In-House Leasing Installment',
                        'route' => 'backend.paymentmethodinstallment.index',
                        'roles' => ['admin'],
                    ],
                    'G4' => [
                        'label' => 'In-House Leasing Process',
                        'route' => 'backend.leasingprocess.index',
                        'roles' => ['admin'],
                    ],
                    'G5' => [
                        'label' => 'Third Party Payment',
                        'route' => 'backend.thirdpartymodule.index',
                        'roles' => ['admin'],
                    ],
                    'G6' => [
                        'label' => 'Third Party Payment Process',
                        'route' => 'backend.thirdpartypaymentprocess.index',
                        'roles' => ['admin'],
                    ],
                    'G7' => [
                        'label' => 'Payment Cost Income',
                        'route' => 'backend.paymentcostincome.index',
                        'roles' => ['admin'],
                    ]
                ]
            ],
            'H' => [
                'label' => 'Marketing',
                'route' => '',
                'icon' => 'fa-lightbulb-o',
                'roles' => ['admin'],
                'submenu' => [
                    'H1' => [
                        'label' => 'Newsletter',
                        'route' => 'backend.newsletter.index',
                        'roles' => ['admin'],
                    ],
                    'H2' => [
                        'label' => 'Commission Rule',
                        'route' => 'backend.commissionrule.index',
                        'roles' => ['admin'],
                    ],
                    'H3' => [
                        'label' => 'Voucher',
                        'route' => 'backend.voucher.index',
                        'roles' => ['admin'],
                    ]
                ]
            ],
            'I' => [
                'label' => 'Master Data',
                'route' => '',
                'icon' => 'fa-book',
                'roles' => ['admin'],
                'submenu' => [
                    'I1' => [
                        'label' => 'Variant Reference',
                        'route' => 'backend.variantreference.index',
                        'roles' => ['admin'],
                    ],
                    'I2' => [
                        'label' => 'Couriers',
                        'route' => 'backend.courier.index',
                        'roles' => ['admin'],
                    ],
                    'I3' => [
                        'label' => 'Provinces',
                        'route' => 'backend.province.index',
                        'roles' => ['admin'],
                    ],
                    'I4' => [
                        'label' => 'Cities',
                        'route' => 'backend.city.index',
                        'roles' => ['admin'],
                    ],
                    'I5' => [
                        'label' => 'Kecamatan',
                        'route' => 'backend.kecamatan.index',
                        'roles' => ['admin'],
                    ],
                    'I6' => [
                        'label' => 'Kelurahan',
                        'route' => 'backend.kelurahan.index',
                        'roles' => ['admin'],
                    ],
                    'I7' => [
                        'label' => 'Banks',
                        'route' => 'backend.bank.index',
                        'roles' => ['admin'],
                    ],
                ]
            ],
            'J' => [
                'label' => 'Reporting',
                'route' => '',
                'icon' => 'fa-line-chart',
                'roles' => ['admin'],
                'submenu' => [
                    'J1' => [
                        'label' => 'Live Report',
                        'route' => 'backend.report.index',
                        'roles' => ['admin'],
                    ]
                ]
            ]
        ],
        "optional_order_purchased_item_classes" => [],
        "max_bank_accounts" => 2
    ],

    'images' => [

        'imageWithThumbnail' => true,

        'imageDestinationPath' => 'public/uploads', // base_path based

        'imageUseAbsolutePath' => false,

        'imageFileNameOnly' => true,

        'imageBasePath' => 'public', // based_path based

        'imageDirectory' => '',

        'imageMaxHeight' => 1800, // based on retina display

        'imageMaxWidth' => 2880, // based on retina display
    ],

    'emailer' => [

        'from' => [
            'address' => env('EMAIL_ADDRESS', 'suitevent@suitmedia.com'),
            'name' => env('EMAIL_NAME', 'suitevent'),
        ],
        'subject' => 'Welcome to E-Commerce',
        'to' => 'test@suitmedia.com',
        'siteurl' => env('SITE_URL', 'http://suitevent.suitdev.com'),
        'sitename' => env('SITE_NAME', 'suitevent'),
        'siteslogan' => env('SITE_SLOGAN', 'We are No. 1'),

        'activation' => ['subject' => 'Aktifasi Akun    '],

        'welcome' => [],

        'alert' => ['parent' => 'welcome', 'subject' => 'alert'],

        'invoice' => [],
    ],

    'emailsettings' => [

        'layout' => 'emails.layout',

        'templates' => [
            'ParticipantNew' => [
                'subject' => 'One More Step to Become SuitEvent Squad',
                'action_button_text' => 'Selesaikan Registrasi',
                'before_action_button' => 'Terima kasih telah bergabung dengan SuitEvent Squad! Tinggal sedikit lagi untuk selesaikan registrasi lo. Lengkapi registrasi lo di sini!',
                'after_action_button' => ''
            ],
            'CommissionApplication' => [
                'subject' => 'Komisi Baru',
                'action_button_text' => 'Lihat Komisi',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'ContactNewMessage' => [
                'subject' => 'Pesan Baru dari Customer',
                'action_button_text' => 'Reply',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'ContactReplyMessage' => [
                'subject' => 'Balasan Pesan Anda',
                'action_button_text' => null,
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'MessageNewInbox' => [
                'subject' => 'Pesan Baru',
                'action_button_text' => 'Balas',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'NewsletterNewNewsletter' => [
                'subject' => 'Newsletter',
                'action_button_text' => null,
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'OrderChangeStatus' => [
                'subject' => 'Perubahan Status Pesanan',
                'action_button_text' => 'Lihat Pesanan',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'OrderNewOrder' => [
                'subject' => 'Pesanan Baru',
                'action_button_text' => 'Lihat Detail',
                'before_action_button' => 'Berikut merupakan detail pesanan Anda:',
                'after_action_button' => 'Terima kasih telah berbelanja di SMILE'
            ],
            'OrderNewOrderAdmin' => [
                'subject' => 'Ada Pesanan Baru di SMILE',
                'action_button_text' => 'Order Detail',
                'before_action_button' => 'Ada pesanan baru di SMILE, silahkan cek detailnya.',
                'after_action_button' => ''
            ],
            'PaymentConfirmationCreatedAdmin' => [
                'subject' => 'Ada Konfirmasi Pembayaran Baru',
                'action_button_text' => 'Lihat Detail Tagihan',
                'before_action_button' => 'Ada konfirmasi tagihan baru, silahkan cek detailnya.',
                'after_action_button' => ''
            ],
            'PaymentConfirmationNew' => [
                'subject' => 'Konfirmasi Pembayaran',
                'action_button_text' => '',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'CustomerInvoiceNew' => [
                'subject' => 'Tagihan Baru',
                'action_button_text' => 'Lihat Detail Tagihan',
                'before_action_button' => 'Berikut merupakan detail tagihan yang perlu Anda bayar:',
                'after_action_button' => ''
            ],
            'CustomerInvoiceChangeStatus' => [
                'subject' => 'Status Tagihan Anda',
                'action_button_text' => 'Lihat Detail Tagihan',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'CustomerInvoiceExpiredInvoice' => [
                'subject' => 'Tagihan Anda Sudah Kedaluwarsa',
                'action_button_text' => 'Lihat Detail Tagihan',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'UserActivated' => [
                'subject' => 'Selamat Datang di E-Commerce)',
                'action_button_text' => 'Mulai Jualan',
                'before_action_button' => 'Buat toko dan dapatkan komisi untuk setiap pembelian produk dari toko kamu atau Diskon setiap membeli di toko mu sendiri',
                'after_action_button' => ''
            ],
            'UserActivation' => [
                'subject' => 'Aktivasi Akun Anda',
                'action_button_text' => 'Aktivasi Akun',
                'before_action_button' => 'Anda telah mengirimkan permintaan aktivasi akun. Silakan klik tombol berikut untuk aktivasi akun Anda.',
                'after_action_button' => ''
            ],
            'PasswordReset' => [
                'subject' => 'Reset Password Link',
                'action_button_text' => 'Reset Password',
                'before_action_button' => 'You are receiving this email because we received a password reset request for your account.',
                'after_action_button' => 'If you did not request a password reset, no further action is required.'
            ],
            'UserRegistered' => [
                'subject' => 'Aktifkan Akun Anda',
                'action_button_text' => 'Aktifkan & Mulai Jualan',
                'before_action_button' => 'Buat toko dan dapatkan komisi untuk setiap pembelian produk dari toko kamu atau Diskon setiap membeli di toko mu sendiri. Silakan klik tombol berikut untuk aktivasi akun Anda.',
                'after_action_button' => ''
            ],
            'VoucherApplication' => [
                'subject' => 'Penggunaan Voucher Baru',
                'action_button_text' => 'Lihat Voucher',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
            'WithdrawApproved' => [
                'subject' => 'Withdraw Disetujui',
                'action_button_text' => 'Lihat Transaksi',
                'before_action_button' => '',
                'after_action_button' => ''
            ],
        ],
    ],

    'couriers' => [
        'codes' => ['jne', 'pos', 'tiki'],
        'default' => 'jne',
    ],
];
