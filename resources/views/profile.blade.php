@extends('layouts.main')

@section('content')
    <div class="app-content content"
    >
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <main class="login-form">
                    <div class="cotainer">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <h3 class="card-header text-center">تغییر رمز</h3>
                                    <div class="card-body">
                                        <form method="POST" action="/password">
                                            @csrf
                                            @include('errors')
                                            <div class="row">


                                                <div class=" col-md-6">

                                                    <br>
                                                    <label>نام کاربری</label>
                                                    <input class="form-control" type="text" id="codemeli" name="codemeli"
                                                           value="{{$user->national_code}}" readonly>
                                                    <br>
                                                    <label>رمز عبور قبلی</label>
                                                    <input type="password" name="old_password" placeholder="" class="form-control" autocomplete="off">

                                                </div>

                                                <div class="col-md-6">
                                                    <br>
                                                    <label>رمز جدید</label>
                                                    <input type="password" name="new_password" placeholder="" class="form-control" autocomplete="off">
                                                    <br>
                                                    <label>تکرار رمز جدید</label>
                                                    <input type="password" name="confirm_password" placeholder="" class="form-control" autocomplete="off">

                                                </div>

                                                <div class="form-group">
                                                    <br>
                                                    <div class="col-md-12 col-lg-12">
                                                        <br>
                                                        <button class="btn btn-primary btn-block">ذخیره و ارسال</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="/assets/js/scripts/sweet/sweetalert.min.js"></script>
    @include('sweet::alert')
@endsection
