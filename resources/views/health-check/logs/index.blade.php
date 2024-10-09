@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Health Check Logs</h1>
    <div class="card">
        <div class="card-header">
            Recent Health Check Logs
        </div>
        <div class="card-body">
            @if($logs->isEmpty())
            <p>No logs found.</p>
            @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Status</th>
                        <th>Message</th>
                        <th>Failure Count</th>
                        <th>Severity</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->service_name }}</td>
                        <td>
                            <span class="badge {{ $log->status === 'OK' ? 'bg-success' : 'bg-danger' }}">
                                {{ $log->status }}
                            </span>
                        </td>
                        <td>{{ $log->message }}</td>
                        <td>{{ $log->failure_count }}</td>
                        <td>{{ $log->severity }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $logs->links() }} <!-- Pagination links -->
            @endif
        </div>
    </div>
</div>
@endsection