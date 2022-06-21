@extends('layouts.home')

@section('content')
    @include('sweet::alert')

@endsection
@section('script')

    <!-- begin::sweet alert demo -->
    @include('sweetalert::alert')
    <!-- begin::sweet alert demo -->
@endsection
