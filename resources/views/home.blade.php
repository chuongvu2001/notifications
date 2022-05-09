@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @foreach(\Illuminate\Support\Facades\Auth::user()->notifications as $notification => $item)
                            @if($notification%2)
                                <div class="alert alert-success d-flex justify-content-between" role="alert">
                                    {{$item->data['name']}}
                                    <div></div>
                                    {{\Carbon\Carbon::now()->diffForHumans($item['create_at'])}}
                                </div>
                            @else
                                <div class="alert alert-info d-flex justify-content-between" role="alert">
                                    {{$item->data['name']}}
                                    <div></div>
                                    {{Carbon\Carbon::parse($item['create_at'])->diffForHumans()}}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

