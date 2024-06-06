@extends('layouts.app')

@section('title', 'Prediction')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Prediction</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-lg-12">
                @include('utils.alerts')
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        {{-- Hasil Prediksi --}}
                        <h1>Prediction Results</h1>
                        @if(isset($predictions) && count($predictions) > 0)
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product Line</th>
                                        <th>Random Forest Regressor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($predictions as $prediction)
                                        <tr>
                                            <td>{{ $prediction['Product_Line'] }}</td>
                                            <td>{{ $prediction['Random_Forest_Regressor'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning" role="alert">
                                No predictions available.
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h2>Accuracy</h2>
                        @if(isset($accuracy) && count($accuracy) > 0)
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Model Name</th>
                                        <th>MSE</th>
                                        <th>RMSE</th>
                                        <th>R-squared</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accuracy as $item)
                                        <tr>
                                            <td>{{ $item['Model_Name'] }}</td>
                                            <td>{{ $item['MSE'] }}</td>
                                            <td>{{ $item['RMSE'] }}</td>
                                            <td>{{ $item['R_squared'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning" role="alert">
                                No accuracy data available.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="/prediction" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Upload File</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
