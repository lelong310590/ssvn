<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
	#cell {
		background-color: #000000;
		color: #ffffff;
	}

	.cell {
		background-color: #000000;
		color: #ffffff;
	}

	tr td {
		background-color: #ffffff;
	}

	tr > td {
		border-bottom: 1px solid #000000;
	}

</style>
<table border="1">
    <tbody>
    <tr>
        <td colspan="{{5 + $course->count()}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 18px">
            {{$company->name}}
        </td>
    </tr>
    <tr>
        <td colspan="{{5 + $course->count()}}" style="text-align: center; text-transform: uppercase; font-weight: 700; font-size: 18px">
            {{$company->mst}}
        </td>
    </tr>
    <tr style="border: 1px solid #000000">
        <td colspan="{{5 + $course->count()}}">
            Danh sách công nhân
        </td>
    </tr>
    <tr style="background-color: #007bff">
        <td rowspan="2" valign="middle">STT</td>
        <td rowspan="2" valign="middle" width="20">Họ và tên</td>
        <td rowspan="2" valign="middle" width="20">Số CMND/CCCD</td>
        <td rowspan="2" valign="middle">Tuổi</td>
        <td rowspan="2" valign="middle" width="20">Số điện thoại</td>
        <td rowspan="1" colspan="{{$registerdSubject->count()}}" style="text-align: center">Danh sách chứng chỉ</td>
    </tr>
    <tr>
        @foreach($registerdSubject as $rs)
            <td class="text-center">{{$rs->name}}</td>
        @endforeach
    </tr>

    @foreach($employers as $e)
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
                    <td style="text-align: center">&#10004;</td>
                @else
                    <td class="text-center">&nbsp;</td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
</html>

