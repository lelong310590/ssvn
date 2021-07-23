<div class="list-company-table {{auth('nqadmin')->user()->hard_role <= 3 ? 'list-company-table-single' : ''}}">
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <td rowspan="2" width="50">STT</td>
                <td rowspan="2" width="150">Họ và tên cấp quản lý</td>
                <td rowspan="2" width="100">Số CMND/CCCD</td>
                <td rowspan="2" width="80">Số điện thoại</td>
                <td rowspan="2" width="50">Tổng số NLĐ quản lý</td>
                <td rowspan="1" colspan="{{$registerdSubject->count()}}" style="text-align: center">Danh sách chứng chỉ</td>
            </tr>
            <tr>
                @foreach($registerdSubject as $rs)
                    <td class="text-center">{{$rs->name}}</td>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @forelse($manager as $e)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$e->first_name}} {{$e->last_name}}</td>
                    <td>{{$e->citizen_identification}}</td>
                    <td>{{$e->phone}}</td>
                    <td>{{$e->get_employer_count}}</td>
                    @php
                        $completedEmployers = $e->getEmployerCertificate;
                    @endphp

                    @foreach($registerdSubject as $c)
                        <th width="150" class="text-center">
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
                    <td colspan="{{4 + $courses->count()}}">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>