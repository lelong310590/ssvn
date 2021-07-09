<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
	        height: 793.7px;
	        width: 1122.52px;
	        font-family: 'Playfair Display', serif;
            font-size: 16px;
        }

        .certificate {
	        height: 793.7px;
	        width: 1122.52px;
            background-image: url({{asset('frontend/images/certificate.jpg')}});
            background-size: cover;
            background-position: top left;
            padding: 37mm;
        }

        .certificate-header {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
        }

	    .certificate-header img {
            margin-right: 25px;
        }

        .certificate-header-block {
            text-align: center;
            font-size: 15px;
            text-transform: uppercase;
        }

        .certificate-block {
            flex: 1;
            font-weight: 700;
	        font-size: 15px;
            text-align: center;
        }

        .certificate-info {
            padding: 0 115px;
            font-size: 18px;
            margin-top: 25px;
            font-weight: 700;
        }

        .certificate-sign {
	        float: right;
	        width: 416px;
	        text-align: center;
            font-weight: 700;
        }

    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-header">
            <img src="{{asset('frontend/images/logo_byt.png')}}" alt="" class="img-responsive" width="100px">
            <div class="certificate-header-block">
                <p style="font-weight: 700">Sở y tế tỉnh Bình Dương</p>
                <p>Số CER-{{1000000 + $certificate->id}}</p>
            </div>
            <div class="certificate-block" style="font-size: 18px">
                <p>Cộng hòa xã hội chủ nghĩa Việt Nam</p>
                <p>Độc lập - Tự do - Hạnh phúc</p>
            </div>
        </div>
        <div class="certificate-main">
            <h1 class="text-center text-uppercase" style="color: red; font-weight: 900;">Giấy chứng nhận đào tạo</h1>
            <div class="certificate-info">
                <p><span style="color: green; text-transform: uppercase; font-size: 23px; margin-left: 154px;">Sở y tế tỉnh Bình Dương</span></p>
                <p>Chứng nhận: <b style="margin-left: 25px">{{$user->sex == 'male' ? 'Ông' : 'Bà'}} {{$user->first_name}}</b></p>
                <p>Đơn vị: <b style="margin-left: 25px">{{$company != null ? $company->name : ''}}</b></p>
                <p>Đã hoàn thành khóa huấn luyện đào tạo:</p>
                <p class="text-center text-uppercase" style="font-size: 18px">{{$course->name}}</p>
            </div>
        </div>
        <div class="certificate-sign">
            <p style="margin-bottom: 90px">Bình Dương, ngày {{$certificate->created_at->format('d')}} tháng {{$certificate->created_at->format('m')}} năm {{$certificate->created_at->format('Y')}}</p>
            <p class="text-uppercase">Giám đốc Sở Y tế tỉnh Bình Dương</p>
            <p class="text-uppercase">Nguyễn Hồng Chương</p>
        </div>
    </div>
</body>
</html>