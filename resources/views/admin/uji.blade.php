@extends('admin.main')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Data Uji</h1>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <th>Text: </th>
                                    <td>{{ $text }}</td>
                                </tr>
                                <tr>
                                    <th>Result: </th>
                                    <td>{{ $result }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Narasi</th>
                                    <th>Label</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataUji as $row)
                                    <tr>
                                        <td>{{ $row['text'] }}</td>
                                        <td>{{ $row['class'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
        </div>
    </div>
@endsection
