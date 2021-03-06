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
                <p style="font-weight: 700">S??? y t??? t???nh B??nh D????ng</p>
                <p>S??? CER-{{1000000 + $certificate->id}}</p>
            </div>
            <div class="certificate-block" style="font-size: 18px">
                <p>C???ng h??a x?? h???i ch??? ngh??a Vi???t Nam</p>
                <p>?????c l???p - T??? do - H???nh ph??c</p>
            </div>
        </div>
        <div class="certificate-main">
            <h1 class="text-center text-uppercase" style="color: red; font-weight: 900;">Gi???y ch???ng nh???n ????o t???o</h1>
            <div class="certificate-info">
                <p><span style="color: green; text-transform: uppercase; font-size: 23px; margin-left: 154px;">S??? y t??? t???nh B??nh D????ng</span></p>
                @if ($type == 'personal')
                    <p>Ch???ng nh???n: <b style="margin-left: 25px">{{$user->sex == 'Nam' ? '??ng' : 'B??'}} {{$user->first_name}} {{$user->last_name}}</b></p>
                    <p>Ng??y sinh: <b style="margin-left: 25px">{{$user->dob->format('d/m/Y')}}</b></p>
                    @if ($company != null)
                        <p>????n v???: <b style="margin-left: 25px">{{$company != null ? $company->name : ''}}</b></p>
                    @endif
                @else
                    <p>Ch???ng nh???n ????n v???: <b style="margin-left: 25px">{{$company != null ? $company->name : ''}}</b></p>
                    <p>?????a ch???: <b style="margin-left: 25px">{{$company->fulladdress}}</b></p>
                @endif
                <p>???? ho??n th??nh kh??a hu???n luy???n ????o t???o:</p>
                <p class="text-center text-uppercase" style="font-size: 18px">{{$subject->name}}</p>
            </div>
        </div>
        <div class="certificate-sign">
            <p style="margin-bottom: 90px">B??nh D????ng, ng??y {{$certificate->created_at->format('d')}} th??ng {{$certificate->created_at->format('m')}} n??m {{$certificate->created_at->format('Y')}}</p>
            <p class="text-uppercase">Gi??m ?????c S??? Y t??? t???nh B??nh D????ng</p>
            <p class="text-uppercase">Nguy???n H???ng Ch????ng</p>
        </div>
    </div>
</body>
</html>