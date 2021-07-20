<html>
<style>
    .text-center {
        text-align: center;
    }
    .text-left {
        text-align: left;
    }
    .text-right {
        text-align: right;
    }
</style>
<table>
    <thead>
    <tr>
        <td colspan="{{2 + $registerdSubject->count() * 4}}" style="text-align: right; font-style: italic">
            Ngày: {{\Carbon\Carbon::now()->day}} - Tháng: {{\Carbon\Carbon::now()->month}} - Năm: {{\Carbon\Carbon::now()->year}}
        </td>
    </tr>
    <tr>
        <td colspan="{{2 + $registerdSubject->count() * 4}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 18px">
            BÁO CÁO THỐNG KÊ SỐ LƯỢNG DOANH NGHIỆP THAM GIA TRONG ĐỊA BÀN
        </td>
    </tr>
    <tr>
        <td colspan="{{2 + $registerdSubject->count() * 4}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 16px">
            @if ($ward != false)
                {{$ward->ward_name}}
            @endif

            @if ($district != false)
                - {{$district->district_name}} -
            @endif

            {{$province->province_name}}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <th width="4.17" rowspan="3" style="vertical-align: top">STT</th>
        @if (request()->get('district') == null)
            <th rowspan="3" width="24.67" style="vertical-align: top">Đơn vị hành chính <br/>Quận / Huyện</th>
        @else
            <th rowspan="3" width="24.67" style="vertical-align: top">Đơn vị hành chính <br/>Phường / Xã</th>
        @endif

        @foreach($registerdSubject as $c)
            <th rowspan="1" colspan="4" class="text-center" height="33" style="white-space: wrap">{{$c->name}}</th>
        @endforeach
    </tr>
    <tr>
        @foreach($registerdSubject as $c)
            <th rowspan="1" colspan="2" class="text-center">Theo Doanh nghiệp</th>
            <th rowspan="1" colspan="2" class="text-center">Theo Người lao động</th>
        @endforeach
    </tr>
    <tr>
        @foreach($registerdSubject as $c)
            <th rowspan="1" colspan="1" class="text-center" width="13.67" height="35">Tổng số DN <br/>tham gia</th>
            <th rowspan="1" colspan="1" class="text-center" width="13.67" height="35">Tổng số DN đạt <br/>chứng chỉ</th>
            <th rowspan="1" colspan="1" class="text-center" width="13.67" height="35">Tổng số NLĐ <br/>tham gia</th>
            <th rowspan="1" colspan="1" class="text-center" width="13.67" height="35">Tổng số NLĐ <br/>đạt chứng chỉ</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @forelse($statByArea as $area)
        @php
            $totalEnjoyCompany = $area->getEnjoynedCompany;
            $totalCompanyCertificate = $area->getCompanyCertificate;
            $totalEnjoyEmployers = $area->getEnjoynedEmployerInCompany;
            $totalEmployerCertificates = $area->getCertificate;
        @endphp
        <tr>
            <td class="text-right">{{$loop->iteration}}</td>
            <td colspan="text-left">{{$area->areaname}}</td>
            @foreach($registerdSubject as $c)

                @php
                    $enjoyEmployerNumber = 0;
                    $certificateEmployerNumber = 0;

                    $enjoyCompanyNumber = 0;
                    $certificateCompanyNumber = 0;
                @endphp

                <td class="text-right">
                    @if($totalEnjoyCompany->count() == 0)
                        0
                    @else
                        @foreach($totalEnjoyCompany as $enjoyCompany)
                            @if ($enjoyCompany->subject == $c->id)
                                @php $enjoyCompanyNumber = $enjoyCompany->total_enjoyed_company @endphp
                                {{$enjoyCompanyNumber}}
                            @else
                                0
                            @endif
                        @endforeach
                    @endif
                </td>
                <td class="text-left">
                    @if($totalCompanyCertificate->count() == 0)
                        0 (0%)
                    @else
                        @foreach($totalCompanyCertificate as $certificateCompany)
                            @if ($certificateCompany->subject_id == $c->id)
                                @php $certificateCompanyNumber = $certificateCompany->total_completed_company @endphp
                                {{$certificateCompanyNumber}}
                                (
                                @if ($enjoyCompanyNumber == 0)
                                    0%
                                @else
                                    {{round($certificateCompanyNumber/$enjoyCompanyNumber, 4)*100}}%
                                @endif
                            )
                            @else
                                0 (0%)
                            @endif
                        @endforeach
                    @endif
                </td>
                <td class="text-right">
                    @if($totalEnjoyEmployers->count() == 0)
                        0
                    @else
                        @foreach($totalEnjoyEmployers as $enjoyEmployer)
                            @if ($enjoyEmployer->subject == $c->id)
                                @php $enjoyEmployerNumber = $enjoyEmployer->total_enjoyed_employer @endphp
                                {{$enjoyEmployerNumber}}
                            @else
                                0
                            @endif
                        @endforeach
                    @endif
                </td>
                <td class="text-left">
                    @if($totalEmployerCertificates->count() == 0)
                        0 (0%)
                    @else
                        @foreach($totalEmployerCertificates as $certificateEmployer)
                            @if ($certificateEmployer->subject_id == $c->id)
                                @php $certificateEmployerNumber = $certificateEmployer->total_completed_employer @endphp
                                {{$certificateEmployerNumber}}
                                (
                                @if ($enjoyEmployerNumber == 0)
                                    0%
                                @else
                                    {{round($certificateEmployerNumber/$enjoyEmployerNumber, 4)*100}}%
                                @endif
                            )
                            @else
                                0 (0%)
                            @endif
                        @endforeach
                    @endif
                </td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{2 + $registerdSubject->count() * 4}}">Không có dữ liệu</td>
        </tr>
    @endforelse
    </tbody>
</table>
</html>