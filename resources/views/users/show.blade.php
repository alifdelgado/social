@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="shadow-sm card">
                    <img class="card-img-top " src="{{ $user->avatar }}" alt="{{ $user->name }}" style="height: 300px;">
                    <div class="card-body">
                        <h5 class="text-center card-title">{{ $user->name }}</h5>
                        <friendship-btn class="btn btn-primary btn-block" :recipient="{{$user}}"></friendship-btn>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <status-list url="{{route('users.statuses.index', $user)}}"></status-list>
            </div>
        </div>
    </div>
@endsection
