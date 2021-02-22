@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 mb-3 shadow-sm">
                <div class="card-body">
                    <status-form></status-form>
                </div>
            </div>
            <status-list></status-list>
        </div>
    </div>
</div>
@endsection
