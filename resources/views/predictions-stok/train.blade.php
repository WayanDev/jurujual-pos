@extends('layouts.app')

@section('title', 'Prediksi Stok')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Predictions Stock</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @if (session('status'))
            <div class="alert alert-info mt-1" id="statusAlert">
                {{ session('status') }}
            </div>
        @endif
        @if (isset($error))
            <div class="alert alert-danger mt-1" id="errorAlert">
                {{ $error }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                @include('utils.alerts')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-1">
                            <form id="trainForm" action="{{ route('train-model-stok') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="button" id="trainButton" class="btn btn-success">Train Model</button>
                            </form>

                            <form id="resetForm" action="{{ route('reset-stok') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" id="resetButton" class="btn btn-danger">Reset Model</button>
                            </form>
                        </div>
                        <hr>
                        <h3>Hasil Evaluasi Model:</h3>
                        @if (session('evaluation'))
                            @php $evaluation = session('evaluation'); @endphp
                            <ul>
                                <li>MSE Training: {{ $evaluation['Training']['MSE'] }}</li>
                                <li>RMSE Training: {{ $evaluation['Training']['RMSE'] }}</li>
                                <li>R-squared Training (R²): {{ $evaluation['Training']['R2'] }}</li>
                            </ul>
                            <ul>
                                <li>MSE Testing: {{ $evaluation['Testing']['MSE'] }}</li>
                                <li>RMSE Testing: {{ $evaluation['Testing']['RMSE'] }}</li>
                                <li>R-squared Testing (R²): {{ $evaluation['Testing']['R2'] }}</li>
                            </ul>
                        @else
                            <p>Belum ada hasil evaluasi yang tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById('trainButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Training Model',
                html: 'Mohon tunggu sampai proses training model selesai...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            document.getElementById('trainForm').submit();
        });
    </script>

    <script>
        document.getElementById('resetButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Reset Model',
                html: 'Mohon tunggu sampai proses reset model selesai...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            document.getElementById('resetForm').submit();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var alert = document.getElementById('statusAlert');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 3000);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var alert = document.getElementById('errorAlert');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 3000);
        });
    </script>
@endsection
