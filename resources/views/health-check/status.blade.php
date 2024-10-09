@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Health Check Status</h1>
    <div class="card">
        <div class="card-header">
            Service Health Check Results
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($results as $service => $result)
                <li class="list-group-item">
                    <strong>{{ ucfirst($service) }}:</strong>
                    @if($result['status'] === 'OK')
                    <span class="badge bg-success">Healthy</span>
                    @else
                    <span class="badge bg-danger">Failed</span>
                    <div class="mt-2">
                        <small><strong>Error Message:</strong> {{ $result['message'] }}</small>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer text-muted">
            Last checked at: {{ now()->toDateTimeString() }}
        </div>
    </div>
</div>
@endsection