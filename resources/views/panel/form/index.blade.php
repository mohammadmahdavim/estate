@extends('layouts.main')
@section('content')


    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">دسته بندی ها</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/users">دسته بندی ها</a>
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
                                    <h5 class="panel-title">دسته ها </h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="panel panel-flat">
                                            <div class="panel-heading">
                                                <div class="heading-elements">
                                                    <div class="heading-btn">
                                                        <a href="{{url('/panel/forms/create')}}" class="btn btn-info">
                                                            <i class="livicon-evo"  data-options="name: plus-alt.svg; size:30px; style: original: 0.05em;"></i>

                                                            ایجاد
                                                            دسته جدید
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table datatable-header-footer">
                                                <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>نام</th>
                                                    <th>ایجاد کننده</th>
                                                    <th>ایجاد شده در</th>
                                                    <th >جزئیات</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach ($forms as $key=>$form)
                                                    <tr>
                                                        <td>{{$key + 1}}</td>
                                                        <td>{{$form->name}}</td>
                                                        <td>{{$form->creator->name}}</td>
                                                        <td>{{\Morilog\Jalali\Jalalian::forge("{$form->created_at}")->format('%d / %m / %y')}}</td>
                                                        <td>
                                                            <a href="{{url('/panel/forms_fields/'.$form->id)}}" title="سوالات">
                                                                <i class="livicon-evo"
                                                                   data-options="name: question-alt.svg ; size:30px; style: original: 0.05em;"></i>
                                                            </a>
                                                            <x-destroy :id="$form->id" url="'/panel/forms/userDestroy'"/>

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

                </section>
            </div>
        </div>
    </div>

    <!-- /Header and footer fixed -->
@endsection
@section('script')
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    @include('sweetalert::alert')

@endsection
