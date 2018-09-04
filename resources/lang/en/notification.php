<?php

return [

    'messages' => [
        'admin' => [
            'orders' => [
                'neworder' => 'Ada pesanan baru :ordernumber',
                'becomemember' => 'User :username with order #:ordernumber is fit to become a member',
                'paymentchallenge' => 'Payment of order #:ordernumber is challenged, please check transaction detail'
            ],
            'escrows' => [
                'newwithdrawal' => 'New withdrawal request (:flow) created by :username'
            ],
            'paymentconfirmations' => [
                'newconfirmation' => 'Payment confirmation for invoice #:invoicenumber was created'
            ],
            'giftcardpaymentconfirmations' => [
                'newconfirmation' => 'Payment confirmation for gift card order #:ordernumber was created'
            ],
            'instagramfeed' => [
                'accesstokenexpired' => 'The Instagram Access Token was invalid, please generate new access token.'
            ]
        ],
        'orders' => [
            'neworder' => 'Berhasil membuat order :ordernumber',
            'changestatus' => 'Status order :ordernumber menjadi :newstatus'
        ],
        'invoices' => [
            'newinvoice' => 'Ada tagihan baru dengan nomor tagihan :invoicenumber',
            'changestatus' => 'Status tagihan :invoicenumber berubah menjadi :newstatus',
            'expiredinvoice' => 'Status tagihan :invoicenumber berubah menjadi :newstatus'
        ],
        'escrows' => [
            'changestatus' => 'Status of deposit #:escrownumber is :newstatus'
        ],
        'users'=> [
            'activated' => 'User has been active',
        ],
        'withdraws' => [
            'approved' => '',
        ],
    ],
];
