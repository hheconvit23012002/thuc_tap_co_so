@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form class="form-inline" id="form-filter">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <div class="col-3">
                                <select class="custom-select select-filter" name="role" id="role">
                                    <option selected>All</option>
                                    @foreach($roles as $role => $value)
                                        <option value="{{ $value }}"  @if((string)$value === $selectedRole) selected @endif>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <div class="col-3">
                                <select class="custom-select select-filter" name="city" id="city">
                                    <option selected>All</option>
                                    @foreach($cities as $city)
                                        <option  @if($city === $selectedCity) selected @endif>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company">Company</label>
                            <div class="col-3">
                                <select class="custom-select select-filter" name="company" id="company">
                                    <option selected>All</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" @if((string)$company->id === $selectedCompany) selected @endif>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>avatar</td>
                                <td>info</td>
                                <td>role</td>
                                <td>position</td>
                                <td>city</td>
                                <td>company</td>
                                <td>delete</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $each)
                            <tr>
                                <td>
                                    <a href="{{ route("admin.$table.show",$each) }}">
                                        {{$each->id}}
                                    </a>
                                </td>
                                <td>
                                    <img src="{{ $each->avatar }}" height="100">
                                </td>
                                <td>
                                    {{$each->name}} - {{ $each->gender_name }}
                                    <br>
                                    <a href="mailto:{{ $each->email }}">{{ $each->email }}</a>
                                    <br>
                                    <a href="tel:{{ $each->phone }}">{{ $each->phone }}</a>
                                </td>
                                <td>
                                    {{ $each->role_name }}
                                </td>
                                <td>
                                    {{ $each->position }}
                                </td>
                                <td>
                                    {{ $each->city }}
                                </td>
                                <td>
                                    {{ optional($each->company)->name }}
                                </td>
                                <td>
                                    <form action="{{ route("admin.$table.destroy",$each) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav class="mt-4">
                        <ul class="pagination pagination-rounded mb-0">
                            {{ $data->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $(".select-filter").change(function () {
                $("#form-filter").submit();
            });
        });
    </script>
@endpush
