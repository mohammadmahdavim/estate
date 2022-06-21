@extends('layouts.main')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">اعضا</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/users">اعضا</a>
                                    </li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/panel/users/create">
                <button class="btn btn-success">افزودن
                    <i class="livicon-evo" data-options="name: plus-alt.svg; size:35px; style: original;"></i>

                </button>
            </a>

            <div class="row" id="basic-table">
                <div class="col-12">
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست افراد</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                <!-- Table with outer spacing -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr style="text-align: center">
                                            <th>نام</th>
                                            <th>کد ملی</th>
                                            <th>موبایل</th>
                                            <th>نقش</th>
                                            <th>عملیات</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr style="text-align: center">
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->national_code}}</td>
                                                <td>{{$user->mobile}}</td>
                                                <td>{{$user->role}}</td>
                                                <td>

                                                    <a title="ویرایش"
                                                       href="/panel/users/{{$user->id}}/edit">

                                                        <i class="livicon-evo"
                                                           data-options="name: pencil.svg; size:30px; style: original;"></i>

                                                    </a>


                                                    <x-destroy :id="$user->id" url="'/panel/users/userDestroy'"/>

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

@endsection



