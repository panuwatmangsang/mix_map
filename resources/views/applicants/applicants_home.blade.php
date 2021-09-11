@extends('applicants.layout')
@section('title','หน้าหลัก')

@section('content')

<body>
    <div class="container" style="margin-top:100px;">
        <div class="row">
            <div class="col-md-3">
                <a type="button" href="{{ route('applicants_show_history') }}" class="btn btn-danger" style="width: 100%;">การฝากประวัติ</a>
                
                <br><br><br>
                
                <div class="card-header" style="height:43px; background-color:#E94242; color:white">
                    <span class="align-top">รายชื่อของคนที่อาจรู้จัก</span>
                </div>
                <div class="card">
                    <div class="card-body" style="width:100%">
                        <table class="table table-hover">
                            <tr>
                                <td>พันธการ ปิงเมือง</td>
                            </tr>
                            <tr>
                                <td>ภาณุวัฒน์ มังสังข์ </td>
                            </tr>
                            <tr>
                                <td>วีรภัทร เยเกอร์</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @if(isset($jobs))
                @foreach($jobs as $job)
                <div class="card">
                    <div class="card-body">

                        <img src="{{ asset('uploads/logo/'.$job->logo) }}" alt="logo" width="100" height="100" style="float:left;">

                        <div class="date" style="float:right;">
                            <p>{{ $job->created_at }}</p>

                            <br><br><br><br><br><br><br><br>

                            <button type="button" class="btn btn-warning">สนใจ</button>

                            <a type="button" href="{{ route('see_detail',$job->jobs_id) }}" class="btn btn-primary">ดูรายละเอียด</a>

                        </div>

                        <div class="jobs_detail" style="float: left;" align="left">
                            <p>ตำแหน่งงาน : {{ $job->jobs_name }}</p>
                            <p>จำนวนที่เปิดรับ : {{ $job->jobs_quantity }}</p>
                            <p>ชื่อบริษัท : {{ $job->jobs_name_company }}</p>
                            <p>สถานที่ตั้งบริษัท : {{ $job->jobs_address }}</p>
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
                @endif
            </div>

            <div class="col-md-3">
                <div class="card-header" style="background-color:#E94242; color:white;">
                    <span class="align-top">งานยอดนิยม</span>
                </div>
                <div class="card">
                    <div class="card-body" style="width:100%;">
                        <table class="table table-hover">
                            <tr>
                                <td>Programmer</td>
                            </tr>
                            <tr>
                                <td>Web Programmer</td>
                            </tr>
                            <tr>
                                <td>Design UX/UI</td>
                            </tr>
                            <tr>
                                <td>Tester</td>
                            </tr>
                            <tr>
                                <td>Mobile Developer</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <br>

                <div class="card-header" style="background-color:#E94242; color:white;">
                    <span class="align-top">งานที่ไม่นิยม</span>
                </div>
                <div class="card">
                    <div class="card-body" style="width:100%;">
                        <table class="table table-hover">
                            <tr>
                                <td>Project Manager</td>
                            </tr>
                            <tr>
                                <td>System Engineer</td>
                            </tr>
                            <tr>
                                <td>System Analyst </td>
                            </tr>
                            <tr>
                                <td>IT Consulting</td>
                            </tr>
                            <tr>
                                <td>IT Support</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <br>
    </div>

</body>


@endsection