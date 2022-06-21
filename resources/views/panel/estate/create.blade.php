@extends('layouts.main')
<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/forms/select/select2.min.css">

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">املاک جدید جدید</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/estates">مشاور املاک</a>
                                    </li>
                                    <li class="breadcrumb-item active">املاک جدید جدید
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
                                    <h4 class="card-title">ایجاد مشاور املاک جدید</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="/panel/estates" method="post">
                                            @csrf
                                            @include('errors')
                                            <div class="row">
                                                <div class="col-md-4">

                                                    <label for="basicInput">نام </label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           value="{{old('name')}}" required
                                                           placeholder="نام  را وارد کنید">
                                                </div>

                                                <div class="col-md-4">

                                                    <label for="basicInput">تلفن 1</label>
                                                    <input type="text" class="form-control" id="phone"
                                                           value="{{old('phone')}}"
                                                           name="phone"
                                                           placeholder="تلفن را وارد کنید">
                                                </div>
                                                <div class="col-md-4">

                                                    <label for="basicInput">تلفن 2</label>
                                                    <input type="text" class="form-control" id="phone2" name="phone2"
                                                           value="{{old('phone2')}}"
                                                           placeholder="تلفن2 را وارد کنید">
                                                </div>
                                                <div class="col-md-6">

                                                    <label for="basicInput">آدرس</label>
                                                    <input type="text" class="form-control" id="address"
                                                           value="{{old('address')}}"
                                                           name="address"
                                                           placeholder="آدرس را وارد کنید">
                                                </div>
                                                <div class="col-md-2">

                                                    <label for="basicInput">مدیر</label>
                                                    <select class="select2 form-control" name="manager" id="manager" required>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4">

                                                    <label for="basicInput">اعضا</label>
                                                    <select class="select2 form-control" multiple name="users[]" id="users[]">
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    <label for="basicInput">توضیحات</label>
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                    <textarea name="description"
                                                              class="form-control">{{old('description')}}</textarea>
                                                    </fieldset>
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
            <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>

@endsection
