@extends('layouts.main')

@section('head')

@stop

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">نقش ها</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/roles">نقش ها</a>
                                    </li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/panel/roles/create">
                <button class="btn btn-success">افزودن
                    <i class="livicon-evo" data-options="name: plus-alt.svg; size:35px; style: original;"></i>

                </button>
            </a>

            <div class="row" id="basic-table">
                <div class="table-responsive">
                    <table class="table zero-configuration">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نقش</th>
                            <th>نام</th>
                            <th>ویرایش شده در</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as$index=> $role)
                            <tr>
                                <th scope="row">{{ $index + $roles->firstItem() }}</th>
                                <td>{{$role->name}}</td>
                                <td>{{$role->label}}</td>
                                <td>{{\Morilog\Jalali\Jalalian::forge("{$role->updated_at}")->ago()}}</td>
                                <td>
                                    <a href="{{url("panel/roles/{$role->id}/edit")}}"
                                       class="btn btn-icon btn-icon rounded-circle btn-info mr-1 mb-1 waves-effect waves-light">
                                        <i class="livicon-evo"
                                           data-options="name: pencil.svg; size:30px; style: original;"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    <!--/ Zero configuration table -->
@stop

@section('script')

@stop
