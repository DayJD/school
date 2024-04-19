@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Submitted Homework</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        <a href="{{ url('admin/homework/homework/add') }}" class="btn btn-primary">เพิ่ม</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search Submitted Homework </h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Name</label>
                                    <input type="text" name="name"
                                        class="form-control"value="{{ Request::get('name') . ' ' . Request::get('lastname') }}"
                                        placeholder="Enter name">
                                </div>
                                <div
                                    class="form-group col-md-4 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/homework/homework/submitted/' . $homework) }}"
                                        class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @include('_message')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Home Work List</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Stident Name</th>
                                <th>Document</th>
                                <th>Description</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($getRecord->isEmpty())
                            <tr>
                                <td class="text-center" colspan="10">Record not found</td>
                            </tr>
                            @else
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->username . ' ' . $value->lastname }}</td>
                                        <td>
                                            @if (!empty($value->getDocumentUrl()))
                                                <a href="{{ $value->getDocumentUrl() }}" class="btn btn-primary"
                                                    download="">Download</a>
                                            @endif
                                        </td>
                                        <td>{!! $value->description !!}</td>
                                        
                                        <td>{{ date('d-m-Y H:i:A', strtotime($value->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if (!empty($getRecord))
                        <div class="p-3 ">
                            {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
