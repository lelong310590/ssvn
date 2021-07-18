<html>
<table>
    <thead>
    <tr>
        <td colspan="{{4 + $course->count() * 2}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 18px">Thống kê các doanh nghiệp trong địa bàn</td>
    </tr>
    <tr>
        <td colspan="{{4 + $course->count() * 2}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 16px">
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
        <th width="5" rowspan="3">STT</th>
        <th rowspan="3" width="25">Tên doanh nghiệp</th>
        <th width="15" rowspan="3">MST</th>
        <th width="15" rowspan="3" class="tex-center">Lao động</th>
        <th rowspan="1" colspan="{{$course->count() * 2}}" style="text-align: center">
            Chứng chỉ
        </th>
    </tr>
    <tr>
        @foreach($course as $c)
            <th width="10" rowspan="1" colspan="2" style="text-align: center">{{$c->name}}</th>
        @endforeach
    </tr>
    <tr>
        @foreach($course as $c)
            <th width="10" rowspan="1" style="text-align: center">Tỷ lệ tham gia (%)</th>
            <th width="10" rowspan="1" style="text-align: center">Tỷ lệ đạt CC (%)</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @forelse($companies as $cpn)
        @php
            $totalEmployers = $cpn->get_users_count;
            $learnedEmployers = $cpn->getLearnedUser;
            $completedEmployers = $cpn->getCertificate;
        @endphp
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$cpn->name}}</td>
            <td>{{$cpn->mst}}</td>
            <td style="text-align: center">{{$totalEmployers}} người</td>
            @foreach($registerdSubject as $c)
                <th width="15" rowspan="1" style="text-align: center">
                    @foreach($learnedEmployers as $l)
                        @if ($l->subject_id == $c->id)
                            {{round($l->total_learned_employer / $totalEmployers, 4)*100}} %
                        @endif
                    @endforeach
                </th>
                <th width="15" rowspan="1" style="text-align: center">
                    @foreach($completedEmployers as $comple)
                        @if ($comple->course_id == $c->id)
                            {{round($comple->total_completed_employer / $totalEmployers, 4)*100}} %
                        @endif
                    @endforeach
                </th>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{4 + $course->count() * 2}}">Không có dữ liệu</td>
        </tr>
    @endforelse
    </tbody>
</table>
</html>