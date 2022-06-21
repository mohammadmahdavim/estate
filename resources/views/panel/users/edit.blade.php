@extends('layouts.main')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">ویرایش اعضا</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/users">اعضا</a>
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش اعضا
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body"><!-- Basic Inputs start -->

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">ویراش اعضا </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="/panel/users/{{$row->id}}"
                                              method="post">
                                            @csrf
                                            @method('PUT')
                                            @include('errors')
                                            <div class="row">
                                                <div class="col-md-4">

                                                    <label for="basicInput">نام </label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           value="{{$row->name}}"
                                                           placeholder="نام  را وارد کنید">
                                                </div>

                                                <div class="col-md-4">

                                                    <label for="basicInput">کد ملی</label>
                                                    <input type="text" class="form-control" id="national_code"
                                                           value="{{$row->national_code}}"
                                                           name="national_code"
                                                           placeholder="کد ملی را وارد کنید">
                                                </div>
                                                <div class="col-md-4">

                                                    <label for="basicInput">موبایل</label>
                                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                                           value="{{$row->mobile}}"
                                                           placeholder="موبایل را وارد کنید">
                                                </div>
                                                <div class="col-md-4">

                                                    <label for="basicInput">نقش</label>
                                                    <select class="form-control" name="role" id="role">
                                                        @foreach($roles as $role)
                                                            <option
                                                                @if($row->role==$role) selected @endif>{{$role}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <br>
                                            <button class="btn btn-block btn-info">ذخیره</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
@endsection
