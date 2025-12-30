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

                    {{ __('You are logged in!') }}

                    @if(session('just_logged_in'))
                        <div class="mt-3 alert alert-info">กำลังไปที่แดชบอร์ด... จะเปลี่ยนหน้าใน 3 วินาที</div>
                        <script>
                            setTimeout(function() {
                                window.location.href = "{{ route('dashboard') }}";
                            }, 3000);
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
