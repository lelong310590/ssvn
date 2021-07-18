<div class="list-company-table {{auth('nqadmin')->user()->hard_role <= 3 ? 'list-company-table-single' : ''}}">
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th width="50" rowspan="2">STT</th>
                <th rowspan="2" width="250">Tên doanh nghiệp</th>
                <th width="100" rowspan="2">MST</th>
                <th width="100" rowspan="2" class="tex-center">Lao động</th>
                <th rowspan="1" colspan="{{$registerdSubject->count()}}" class="text-center">
                    Chứng chỉ
                </th>
            </tr>
            <tr>
                @foreach($registerdSubject as $c)
                    <th width="150" rowspan="1" colspan="1" class="text-center">{{$c->name}}</th>
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
                    <td class="text-center">{{$totalEmployers}}</td>
                    @foreach($registerdSubject as $c)
                        <th width="150" class="text-center">
                            @foreach($completedEmployers as $comple)
                                @if ($comple->subject_id == $c->id)
                                    {{round($comple->total_completed_employer / $totalEmployers, 4)*100}} %
                                @endif
                            @endforeach
                        </th>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{4 + $courses->count() * 2}}">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{--                                                        <small style="color: red; margin: 0 0 15px"><span>*</span> Thống kê ko bao gồm chủ doanh nghiệp và cấp quản lý</small>--}}
    </div>
</div>