<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<table border="1">
    <tbody>
    <tr>
        <td colspan="{{5 + $course->count()}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 18px">
            {{$company->name}} - MST: {{$company->mst}}
        </td>
    </tr>
    <tr>
        <td colspan="{{5 + $course->count()}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 18px">
            Báo cáo thống kê chứng chỉ
        </td>
    </tr>
    <tr>
        <td colspan="{{5 + $registerdSubject->count()}}">
            Danh sách người lao động
            @if (auth()->user()->hard_role == 2)
                - quản lý bởi {{auth()->user()->first_name}} {{auth()->user()->last_name}}
            @endif
        </td>
    </tr>
    <tr>
        <td rowspan="2" width="4.17">STT</td>
        <td rowspan="2" width="24.67">Họ và tên</td>
        <td rowspan="2" width="24.67">Số CMND/CCCD</td>
        <td rowspan="2" width="24.67">Tuổi</td>
        <td rowspan="2" width="24.67">Số điện thoại</td>
        <td rowspan="1" colspan="{{$registerdSubject->count()}}" style="text-align: center">Danh sách chứng chỉ</td>
    </tr>
    <tr>
        @foreach($registerdSubject as $rs)
            <td class="text-center" width="50">{{$rs->name}}</td>
        @endforeach
    </tr>

    @forelse($employers as $e)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$e->first_name}} {{$e->last_name}}</td>
            <td>{{$e->citizen_identification}}</td>
            <td>{{\Carbon\Carbon::parse($e->dob)->age}}</td>
            <td>{{$e->phone}}</td>
            @php
                $completedCourse = $e->getCertificate()->select('subject_id')->get()->toArray();
                $array = [];
                foreach ($completedCourse as $cc) {
                    $array[] = $cc['subject_id'];
                }
            @endphp
            @foreach($registerdSubject as $c)
                @if (in_array($c->id, $array))
                    <td class="text-center">&#10004;</td>
                @else
                    <td class="text-center">&nbsp;</td>
                @endif
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{4 + $courses->count()}}">Không có dữ liệu</td>
        </tr>
    @endforelse
    </tbody>
</table>
</html>

