<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default tax rate
    |--------------------------------------------------------------------------
    |
    | This default tax rate will be used when you make a class implement the
    | Taxable interface and use the HasTax trait.
    |
    */

    'tax' => 10,

    /*
    |--------------------------------------------------------------------------
    | Shoppingcart database settings
    |--------------------------------------------------------------------------
    |
    | Here you can set the connection that the shoppingcart should use when
    | storing and restoring a cart.
    |
    */

    'database' => [

        'connection' => null,

        'table' => 'shoppingcart',

    ],

    /*
    |--------------------------------------------------------------------------
    | Destroy the cart on user logout
    |--------------------------------------------------------------------------
    |
    | When this option is set to 'true' the cart will automatically
    | destroy all cart instances when the user logs out.
    |
    */

    'destroy_on_logout' => false,

    /*
    |--------------------------------------------------------------------------
    | Default number format
    |--------------------------------------------------------------------------
    |
    | This defaults will be used for the formated numbers if you don't
    | set them in the method call.
    |
    */

    'format' => [

        'decimals' => 0,

        'decimal_point' => '.',

        'thousand_seperator' => ','

    ],

    // Cài đặt kết nối ngân lượng
    'nganluong' => [
        'url_api' => env('URL_API', 'https://sandbox.nganluong.vn:8088/nl30/checkout.api.nganluong.post.php'),
        'receiver' => env('RECEIVER', 'demo@nganluong.vn'),
        'merchant_id' => env('MERCHANT_ID', '36680'),
        'merchant_pass' => env('MERCHANT_PASS', 'matkhauketnoi'),
        'return_url' => env('NL_RETURN_URL'),
        'cancel_url' => env('NL_CANCEL_URL'),
    ],

    // ảnh logo ngân hàng nếu cần thiết
    'nganhang' => [
        'image' => [
            'VCB' => 'assets/images/cash/vcb.png',
            'DAB' => 'assets/images/cash/dong-a.png',
            'TCB' => 'assets/images/cash/tcb.png',
            'MB' => 'assets/images/cash/mbbank.png',
            'VIB' => 'assets/images/cash/vib.png',
            'ICB' => 'assets/images/cash/vietinbank.png',
            'EXB' => 'assets/images/cash/eximbank.png',
            'ACB' => 'assets/images/cash/acb.png',
            'HDB' => 'assets/images/cash/hdbank.png',
            'MSB' => 'assets/images/cash/maritimebank.png',
            'NVB' => 'assets/images/cash/nvb.png',
            'VAB' => 'assets/images/cash/vab.png',
            'VPB' => 'assets/images/cash/vpbank.png',
            'SCB' => 'assets/images/cash/sacombank.png',
            'BAB' => 'assets/images/cash/bac_a.jpg',
            'GPB' => 'assets/images/cash/gpbank.png',
            'AGB' => 'assets/images/cash/agribank.png',
            'BIDV' => 'assets/images/cash/bidv.png',
            'OJB' => 'assets/images/cash/oceanbank.png',
            'PGB' => 'assets/images/cash/pgb.png',
            'SHB' => 'assets/images/cash/shbbank.png',
            'TPB' => 'assets/images/cash/TPBank.png',
            'NAB' => 'assets/images/cash/nama.png',
            'SGB' => 'assets/images/cash/saigonbank.png',

        ],
    ],

];