<div class="list-company-table {{auth('nqadmin')->user()->hard_role <= 3 ? 'list-company-table-single' : ''}}">
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th width="50" rowspan="3">STT</th>
                    @if (request()->get('district') == null)
                        <th rowspan="3" width="250">Đơn vị hành chính <br/>Quận / Huyện</th>
                    @else
                        <th rowspan="3" width="250">Đơn vị hành chính <br/>Phường / Xã</th>
                    @endif

                    @foreach($registerdSubject as $c)
                        <th width="150" rowspan="1" colspan="4" class="text-center">{{$c->name}}</th>
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
                        <th rowspan="1" colspan="1" class="text-center">Tổng số DN tham gia</th>
                        <th rowspan="1" colspan="1" class="text-center">Tổng số DN đạt chứng chỉ</th>
                        <th rowspan="1" colspan="1" class="text-center">Tổng số NLĐ tham gia</th>
                        <th rowspan="1" colspan="1" class="text-center">Tổng số NLĐ đạt chứng chỉ</th>
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
                    <td>{{$loop->iteration}}</td>
                    <td>{{$area->areaname}}</td>
                    @foreach($registerdSubject as $c)

                        @php
                            $enjoyEmployerNumber = 0;
                            $certificateEmployerNumber = 0;

                            $enjoyCompanyNumber = 0;
                            $certificateCompanyNumber = 0;
                        @endphp

                        <td width="150" class="text-center">
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
                        <td width="150" class="text-center">
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
                        <td width="150" class="text-center">
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
                        <td width="150" class="text-center">
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
    </div>
</div>