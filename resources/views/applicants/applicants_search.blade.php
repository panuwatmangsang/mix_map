@extends('applicants.layout')
@section('title','หางาน')

@section('content')

<body>
    <div class="container" align="center" style="margin-top: 50px;">
        <div class="row">

            <!-- text search -->
            <div class="col-md-12" style="margin-top:20px;">
                {!! Form::open(['route' => 'search','method' => 'get']) !!}
                <div class="input-group" style="margin-top:20px;">
                    <input type="text" class="form-control" style="width: 100%;" name="query" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="search jobs...">
                </div>
                {!! Form::close() !!}
            </div>

            <div class="col-md-12" align="center">
                @if(isset($results))
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ชื่อบริษัท</th>
                            <th scope="col">ตำแหน่งงาน</th>
                            <th scope="col">สถานที่ตั้ง</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results["hits"]["hits"] as $result)
                        <!-- echo ($result); -->
                        <tr>
                            <th scope="row">{{ $result['_source']['jobs_name_company']}}</th>
                            <td>{{ $result['_source']['jobs_name'] }}</td>
                            <td>{{ $result['_source']['jobs_address'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        <br>

        <div class="row">
            <!-- left side -->
            <div class="col-md-4 left-side" align="center">
                <div class="card">
                    <div class="card-header">
                        รายละเอียดการค้นหา
                    </div>

                    <div class="card-body">
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ตำแหน่งงาน
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <br>
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ประเภทงาน
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <br>
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ชื่อบริษัท
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <br>
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                วันที่ลงประกาศ
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- main -->
            <!-- display search -->
            <div class="col-md-8">
                @if(isset($results))
                @foreach($results["hits"]["hits"] as $result)

                <div class="card">
                    <div class="card-body">

                        <img src="{{ asset('uploads/logo/'.$result['_source']['logo']) }}" alt="Lamp" width="100" height="100" style="float:left;">

                        <div class="date" style="float: right;">
                            <p>{{ $result['_source']['created_at'] }}</p>

                            <br><br><br><br><br>

                            <a type="button" href="{{ route('see_detail',$result['_source']['jobs_id']) }}" class="btn btn-primary">ดูรายละเอียด</a>
                        </div>

                        <div class="jobs_detail" style="float: left;" align="left">
                            <p>ตำแหน่งงาน : {{ $result['_source']['jobs_name'] }}</p>
                            <p>ชื่อบริษัท : {{ $result['_source']['jobs_name_company'] }}</p>
                            <p>ที่อยู่ : {{ $result['_source']['jobs_address'] }}</p>
                            <p>จำนวนที่รับ : {{ $result['_source']['jobs_quantity'] }}</p>
                            <p>จำนวนที่รับ : {{ $result['_source']['jobs_salary'] }}</p>
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
                @endif


                <!-- display data from dtrabase -->
                @if(isset($ent_post))
                @foreach($ent_post as $ent)
                <div class="card">
                    <div class="card-body">

                        <img src="{{ asset('uploads/logo/'.$ent->logo) }}" alt="Lamp" width="100" height="100" style="float:left;">

                        <div class="date" style="float: right;">
                            <p>{{ $ent->created_at }}</p>

                            <br><br><br><br><br>

                            <a type="button" href="{{ route('see_detail',$ent->jobs_id) }}" class="btn btn-primary">ดูรายละเอียด</a>
                        </div>

                        <div class="jobs_detail" style="float: left;" align="left">
                            <p>ตำแหน่งงาน : {{ $ent->jobs_name }}</p>
                            <p>ชื่อบริษัท : {{ $ent->jobs_name_company }}</p>
                            <p>ที่อยู่ : {{ $ent->jobs_address }}</p>
                            <p>จำนวนที่รับ : {{ $ent->jobs_quantity }}</p>
                            <p>จำนวนที่รับ : {{ $ent->jobs_salary }}</p>
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
                @endif
            </div>
        </div>

    </div>
</body>

@endsection