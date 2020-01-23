@extends('layout')
@section('title', 'Edit')

@section('content')

    <h3>Edit {{ $user->name }}'s data</h3>

    <form method="POST" action="/user/{{ $user->user_id }}">
        @method('PATCH')
        @csrf

        <div class="col-sm-4">

            <div class="form-group row">
                <label class="form-label" for="name">Name:</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}" required>
            </div>

            <div class="form-group row">
                <label class="form-label" for="sectors">Sectors:</label>
                <select class="form-control" name="sectors[]" id="sectors" multiple size="10" required>
                    @foreach($sectors as $key => $sector)
                        <option style="padding-left: {{ $sector->level_id }}em;"
                                value="{{ $sector->sector_id }}"
                            {{ in_array($sector->sector_name, $user_sectors) ? 'selected' : '' }}>
                            {{ $sector->sector_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="agreed_terms" id="agreeterms" required {{ $user->agreed_terms == 1 ? 'checked' : '' }}>
                <label for="agreeterms" class="form-check-label">Agree to terms</label>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Update</button>
            <button type="submit" class="btn btn-danger" form="form_delete">Delete</button>
            <a class="btn btn-default" role="button" href="/">Back</a>

        </div>

    </form>

    <form method="POST" action="/user/{{ $user->user_id }}" id="form_delete">
        @method('DELETE')
        @csrf
    </form>


@endsection
