@extends('layouts.admin.admin')

@section('content-title', 'Dashboard')

@section('content-body')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    Selamat datang&nbsp; <b>{{ auth()->user()->name }}</b>.
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection
