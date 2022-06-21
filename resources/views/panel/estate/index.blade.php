@extends('layouts.main')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">مشاور املاک ها</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/estates">مشاور املاک ها</a>
                                    </li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/panel/estates/create">
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
                                            <th>مدیر</th>
                                            <th>آدرس</th>
                                            <th>تلفن1</th>
                                            <th>تلفن2</th>
                                            <th>اعضا</th>
                                            <th>عملیات</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($estates as $estate)
                                            <tr style="text-align: center">
                                                <td>{{$estate->name}}</td>
                                                <td>{{$estate->managerUser->name}}</td>
                                                <td>{{$estate->address}}</td>
                                                <td>{{$estate->phone}}</td>
                                                <td>{{$estate->phone2}}</td>
                                                <td>
                                                    @foreach($estate->users as $user)
                                                        <button class="btn btn-light-primary btn-sm">{{$user->name}}</button>
                                                    @endforeach
                                                </td>
                                                <td>

                                                    <a title="ویرایش"
                                                       href="/panel/estates/{{$estate->id}}/edit">

                                                        <i class="livicon-evo"
                                                           data-options="name: pencil.svg; size:30px; style: original;"></i>

                                                    </a>


                                                    <x-destroy :id="$estate->id" url="'/panel/estates/estatesDestroy'"/>

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



