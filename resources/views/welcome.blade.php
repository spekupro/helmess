@extends('layout')
@section('title', 'Register form')

@section('content')

    <div class="row">
        <div class="col-sm-6">
            <h3>Please enter your name and pick the Sectors you are currently involved in</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <form method="POST" action="/">
            @csrf

            <div class="form-group row">
                <label class="form-label" for="name">Name:</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group row">
                <label class="form-label" for="sectors">Sectors:</label>
                <select class="form-control" name="sectors[]" id="sectors" multiple size="10" required>
                    @foreach($sectors as $sector)
                        <option style="padding-left: {{ $sector->level_id }}em;"
                                value="{{ $sector->sector_id }}"
                                {{ collect(old('sectors'))->contains($sector->sector_id) ? 'selected' : '' }}>
                                {{ $sector->sector_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="agreed_terms" id="agreeterms" required {{ old('agreed_terms') == 'on' ? 'checked' : '' }}>
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

                <button type="submit" class="btn btn-primary">Save</button>

        </form>
    </div>


    <div class="col-sm-6 pull-right">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 30%">Name</th>
                    <th style="width: 70%">Sectors</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)

                    <tr {{ $rowId = $user->user_id }}>
                        <td rowspan="{{ sizeof(\App\User::getUserSectors($user->user_id)) > 2 ? '3' : sizeof(\App\User::getUserSectors($user->user_id)) }}" id="{{ $user->user_id }}">
                            <a href="/user/{{ $user->user_id }}/edit">{{ $user->name }}</a>
                        </td>
                        <!-- {{ $count = 0 }} -->
                        @foreach(\App\User::getUserSectors($user->user_id) as $key => $sector)

                            @if($count > 1) <tr class="{{ $count >= 2 ? 'hideRow' : '' }} {{ $rowId }}"> @endif
                                <td>{{ $sector }}</td></tr>
                            @if($count == sizeof(\App\User::getUserSectors($user->user_id)) - 1 && $count > 1)
                                <tr>
                                    <td onclick="showMore({{ $rowId.', '.sizeof(\App\User::getUserSectors($user->user_id)) }})" class="showHideBtn-{{$rowId}}" style="cursor:pointer ; font-weight: bold">Show more...</td>
                                </tr>
                            @endif
                            <!-- {{ $count ++ }} -->
                        @endforeach
                @endforeach

            </tbody>
        </table>
        {{ $users->links() }}
    </div>

@endsection
