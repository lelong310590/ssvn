<html>
<table>
    <thead>
    <tr>
        <td colspan="{{3 + $registerdSubject->count()}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 18px">Thống kê các doanh nghiệp trong địa bàn</td>
    </tr>
    <tr>
        <td colspan="{{3 + $registerdSubject->count()}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 16px">
            @if ($ward != false)
                {{$ward->ward_name}}
            @endif

            @if ($district != false)
                - {{$district->district_name}} -
            @endif

            {{$province->province_name}}
        </td>
    </tr>
    <tr>
        <th width="5" rowspan="2">STT</th>
        @if (request()->get('district') == null)
            <th rowspan="2" width="25">Đơn vị hành chính <br/>Quận / Huyện</th>
        @else
            <th rowspan="2" width="25">Đơn vị hành chính <br/>Phường / Xã</th>
        @endif
        <th width="15" rowspan="2">Tổng số doanh nghiệp tham gia</th>
        <th rowspan="1" colspan="{{$registerdSubject->count()}}" style="text-align: center">
            Số lượng NLĐ đạt chứng chỉ
        </th>
    </tr>
    <tr>
        @foreach($registerdSubject as $c)
            <th width="10" rowspan="1" colspan="1" class="text-center">{{$c->name}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
        @forelse($statByArea as $cpn)
            @php
                $completedEmployers = $cpn->getCertificate;
            @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$cpn->areaname}}</td>
                <td class="text-center">{{$cpn->get_company_count}}</td>
                @foreach($registerdSubject as $c)
                    <th width="15" class="text-center">
                        @foreach($completedEmployers as $comple)
                            @if ($comple->subject_id == $c->id)
                                {{$comple->total_completed_employer}}
                            @endif
                        @endforeach
                    </th>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{3 + $registerdSubject->count()}}">Không có dữ liệu</td>
            </tr>
        @endforelse
    </tbody>
</table>
</html>