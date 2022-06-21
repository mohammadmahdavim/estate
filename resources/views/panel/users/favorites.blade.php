@extends('layouts.main')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">علاقه مندی ها</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="">علاقه مندی ها</a>
                                    </li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row" id="basic-table">
                <div class="col-12">
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست علاقه مندی ها</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                <!-- Table with outer spacing -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr style="text-align: center">
                                            <th>تصویر</th>
                                            <th>نام</th>
                                            <th>تاریخ آگهی از</th>
                                            <th>تاریخ آگهی تا</th>
                                            <th>موبایل</th>
                                            <th>عملیات</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user->favorite as $favorite)
                                            <tr style="text-align: center">
                                                <td>{{$favorite->title}}</td>
                                                <td>{{$favorite->title}}</td>
                                                <td>{{$favorite->date_from}}</td>
                                                <td>{{$favorite->date_to}}</td>
                                                <td>{{$favorite->mobile}}</td>
                                                <td>
                                                <a title="حذف" href="/panel/users/delete-favorites/{{$favorite->id}}">
                                                            <i class="livicon-evo"
                                                               data-options="name: star.svg; size:27px; style: original;"></i>

                                                        </a>

                                                </td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    @include('sweetalert::alert')

@endsection



