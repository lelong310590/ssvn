<div class="list-company-table {{auth('nqadmin')->user()->hard_role <= 3 ? 'list-company-table-single' : ''}}">
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <td colspan="{{5 + $registerdSubject->count()}}">
                    Danh sách công nhân
                </td>
            </tr>
            <tr>
                <td rowspan="2" width="50">STT</td>
                <td rowspan="2" width="100">Họ và tên</td>
                <td rowspan="2" width="100">Số CMND/CCCD</td>
                <td rowspan="2" width="50">Tuổi</td>
                <td rowspan="2" width="80">Số điện thoại</td>
                <td rowspan="1" colspan="{{$registerdSubject->count()}}" style="text-align: center">Danh sách chứng chỉ</td>
            </tr>
            <tr>
                @foreach($registerdSubject as $rs)
                    <td class="text-center">{{$rs->name}}</td>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @php
                $i = $employers->perPage() * ($employers->currentPage() - 1) + 1
            @endphp
            @forelse($employers as $e)
                <tr>
                    <td>{{$i++}}</td>
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
                    <td colspan="{{4 + $courses->count() * 2}}">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="vj-paging">
        {{ $employers->appends(request()->input())->render('vendor.pagination.default') }}
    </div>
</div>