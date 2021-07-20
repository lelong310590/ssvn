<div class="list-company-table {{auth('nqadmin')->user()->hard_role <= 3 ? 'list-company-table-single' : ''}}">
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th width="50" rowspan="2">STT</th>
                <th rowspan="2" width="250">Tên doanh nghiệp</th>
                <th width="100" rowspan="2">Mã số thuế DN</th>
                <th width="100" rowspan="2" class="tex-center">Tổng số lao động</th>
                @foreach($registerdSubject as $c)
                    <th width="150" rowspan="1" colspan="2" class="text-center">{{$c->name}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($registerdSubject as $c)
                    <th colspan="1" rowspan="1" class="text-center">Tổng số NLĐ tham gia</th>
                    <th colspan="1" rowspan="1" class="text-center">Tổng số NLĐ có chứng chỉ</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @forelse($companies as $cpn)
                @php
                    $totalEnjoyEmployers = $cpn->getEnjoynedEmployerInCompany;
                    $totalEmployerCertificates = $cpn->getCertificate;
                    $totalEmployers = $cpn->get_users_count;
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$cpn->name}}</td>
                    <td>{{$cpn->mst}}</td>
                    <td class="text-center">{{$totalEmployers}}</td>
                    @foreach($registerdSubject as $c)

                        @php
                            $enjoyEmployerNumber = 0;
                            $certificateEmployerNumber = 0;
                        @endphp

                        <th width="150" class="text-center">
                            @if($totalEnjoyEmployers->count() == 0)
                                0 (0%)
                            @else
                                @foreach($totalEnjoyEmployers as $enjoyEmployer)
                                    @if ($enjoyEmployer->subject == $c->id)
                                        @php $enjoyEmployerNumber = $enjoyEmployer->total_enjoyed_employer @endphp
                                        {{$enjoyEmployerNumber}} ({{round($enjoyEmployerNumber/$totalEmployers, 4)*100}})%
                                    @else
                                        0 (0%)
                                    @endif
                                @endforeach
                            @endif
                        </th>
                        <th width="150" class="text-center">
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
                                            {{round($certificateEmployerNumber/$totalEmployers, 4)*100}}%
                                        @endif
                                    )
                                    @else
                                        0 (0%)
                                    @endif
                                @endforeach
                            @endif
                        </th>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{4 + $registerdSubject->count()}}">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>