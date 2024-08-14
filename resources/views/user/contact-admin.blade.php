@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contact Admin</h1>
    <form method="POST" action="{{ route('user.contact-admin') }}">
        @csrf
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>
@endsection
