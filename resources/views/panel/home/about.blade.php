@extends('layouts.main')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">درباره ما</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">درباره ما</a>
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
                                    <h4 class="card-title">درباره ما</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="/panel/store-about" method="post">
                                            @csrf
                                            <div class="block-body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="form-group">
                                                            <label>عنوان</label>
                                                            <input name="title" required type="text" value="{{$row->title}}"
                                                                   class="form-control simple">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label>توضیحات</label>
                                                    <textarea name="body" required
                                                              class="form-control simple">{{$row->body}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>قوانین</label>
                                                    <textarea name="privacy" required
                                                              class="form-control simple">{{$row->privacy
}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-success btn-block" type="submit">
                                                        ارسال
                                                    </button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
@section('script')


    <!-- begin::sweet alert demo -->
    @include('sweetalert::alert')
    <!-- begin::sweet alert demo -->
@endsection
