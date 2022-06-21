@extends('layouts.main')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">ویرایش املاک</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/estates">املاک</a>
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش املاک
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
                                    <h4 class="card-title">ویراش املاک </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="/panel/estates/{{$row->id}}"
                                              method="post">
                                            @csrf
                                            @method('PUT')
                                            @include('errors')
                                            <div class="row">
                                                <div class="col-md-4">

                                                    <label for="basicInput">نام </label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           value="{{$row->name}}" required
                                                           placeholder="نام  را وارد کنید">
                                                </div>

                                                <div class="col-md-4">

                                                    <label for="basicInput">تلفن 1</label>
                                                    <input type="text" class="form-control" id="phone"
                                                           value="{{$row->phone}}"
                                                           name="phone"
                                                           placeholder="تلفن را وارد کنید">
                                                </div>
                                                <div class="col-md-4">

                                                    <label for="basicInput">تلفن 2</label>
                                                    <input type="text" class="form-control" id="phone2" name="phone2"
                                                           value="{{$row->phone2}}"
                                                           placeholder="تلفن2 را وارد کنید">
                                                </div>
                                                <div class="col-md-6">

                                                    <label for="basicInput">آدرس</label>
                                                    <input type="text" class="form-control" id="address"
                                                           value="{{$row->address}}"
                                                           name="address"
                                                           placeholder="آدرس را وارد کنید">
                                                </div>
                                                <div class="col-md-2">

                                                    <label for="basicInput">مدیر</label>
                                                    <select class="select2 form-control" name="manager" id="manager" required>
                                                        @foreach($users as $user)
                                                            <option @if($user->id==$row->manager) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4">

                                                    <label for="basicInput">اعضا</label>
                                                    <select class="select2 form-control" multiple name="users[]" id="users[]">
                                                        @foreach($users as $user)
                                                            <option
                                                                @if(in_array($user->id, $row->users->pluck('id')->all()))  selected @endif
                                                            value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    <label for="basicInput">توضیحات</label>
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                    <textarea name="description"
                                                              class="form-control">{{$row->description}}</textarea>
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
@endsection
