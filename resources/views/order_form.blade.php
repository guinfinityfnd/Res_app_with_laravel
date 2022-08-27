<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="/dist/css/adminlte.min.css?v=3.2.0">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif
                <h4>Customer Page </h4>
            </div>
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1 d-flex justify-content-between">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">New Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="true">Order List</a>
                            </li>
                        </ul>
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a href="dish" class="nav-link">Kitchen</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                            <form action="{{ route('order.submit') }}" method="post">
                                @csrf
                                <div class="row">
                                    @foreach ($dishes as $dish)
                                    <div class="col-sm-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{ url('/images/'.$dish->image) }}" alt="img" width="100px;" height="100px;"><br>
                                                <label for="">{{ $dish->name }}</label><br>
                                                <input type="number" name="{{$dish->id}}"><br>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="table">Choose Your Table :</label>
                                    <select name="table">
                                        @foreach ($tables as $table)
                                        <option class="form-class" value="{{ $table->id }}">{{ $table->number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">order now</button>
                            </form>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Dish Name</th>
                                        <th>Table Number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->dish->name }}</td>
                                        <td>{{ $order->table_id }}</td>
                                        <td>{{$status [$order->status] }}</td>
                                        <td class="d-flex">
                                            <div class="mr-4">
                                                <a href="/order/{{$order->id}}/serve" class="btn btn-success">Serve</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="/plugins/jquery/jquery.min.js"></script>

                <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
<!--  -->

</html>