<div class="list-company-table {{auth('nqadmin')->user()->hard_role <= 3 ? 'list-company-table-single' : ''}}">
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th width="50" rowspan="2">STT</th>
                @if (request()->get('district') == null)
                    <th rowspan="2" width="250">Đơn vị hành chính <br/>Quận / Huyện</th>
                @else
                    <th rowspan="2" width="250">Đơn vị hành chính <br/>Phường / Xã</th>
                @endif

                <th width="100" rowspan="2">Tổng số doanh nghiệp tham gia</th>
                <th rowspan="1" colspan="{{$registerdSubject->count()}}" class="text-center">
                    Số lượng NLĐ đạt chứng chỉ
                </th>
            </tr>
            <tr>
                @foreach($registerdSubject as $c)
                    <th width="150" rowspan="1" colspan="1" class="text-center">{{$c->name}}</th>
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
                    <td colspan="{{3 + $courses->count()}}">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>