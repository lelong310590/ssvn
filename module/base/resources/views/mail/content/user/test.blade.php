<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anticovid</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="mail-wrapper" style="background-color: #eee; padding: 100px 0; font-family: 'Roboto', sans-serif;">
        <div class="mail-inner" style="
            display: block;
            margin: 0 auto;
            max-width: 480px;
            width: 100%;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 2px rgba(0,0,0,.1);
        ">
            <div class="mail-logo" style="padding: 25px; background-color: #ff9700; color: #fff">
                <h1 style="
                    text-align: center;
                    margin: 0 0 35px;
                    font-size: 20px;
                    text-transform: uppercase;
                ">Cảm ơn bạn đã đăng ký</h1>
                <img src="{{asset('frontend/images/icons/logo.png')}}" alt="" class="img-responsive" style="margin: 0 auto 25px; display: block">
                <p style="text-align: center">Cùng chung tay đổi lùi đại dịch Covid 19</p>
            </div>
            <div class="mail-content" style="padding: 25px">
                <p>Thông tin dùng để đăng nhập hệ thống của bạn là:</p>
                <p style="font-size: 13px; font-style: italic">Tài khoản: <b>12345679</b></p>
                <p style="font-size: 13px; font-style: italic">Mật khẩu: <b>12345679</b></p>
                <p style="text-align: center">
                    <a
                        href="{{route('front.home.index.get')}}"
                        style="
                            background-color: #ff9700;
                            max-width: 200px;
                            text-align: center;
                            display: inline-block;
                            margin: 25px auto 0;
                            color: #fff;
                            text-decoration: none;
                            padding: 15px 35px;
                            border-radius: 4px;
                            font-size: 18px;
                        "
                    >Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>