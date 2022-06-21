@extends('layouts.main')

@section('content')
    @include('sweet::alert')

@endsection
@section('script')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <form method="post" action="/sector" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file">
                    <button type="submit">
                        sabt
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- begin::sweet alert demo -->
    @include('sweetalert::alert')
    <!-- begin::sweet alert demo -->
@endsection
