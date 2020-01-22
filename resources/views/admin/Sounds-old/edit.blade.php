@extends('admin.template.layout')

@section('content')  

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong>There are some problems with your input. <br><br>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Client</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
       
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Client</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <input type="hidden" name="_method" value="put">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Client Name</label>
                    <input type="text" name="name" value="{{ $client->name }}" class="form-control" placeholder="Client Name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="text" name="email" value="{{ $client->email }}" class="form-control" placeholder="Email Id">
                  </div>
                </div>  
                <input type="hidden" name="password" value="{{ $client->password }}" class="form-control">
               
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="text" name="phone" value="{{ $client->phone }}" class="form-control" placeholder="Phone">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Description</label>
                    <input type="text" name="description" value="{{ $client->description }}" class="form-control" placeholder="Description">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" name="address" value="{{ $client->address }}" class="form-control" placeholder="Address">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Pin code</label>
                    <input type="text" name="pincode" value="{{ $client->pincode }}" class="form-control" placeholder="Pincode">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">City</label>
                    <input type="text" name="city" value="{{ $client->city }}" class="form-control" placeholder="City">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Country</label>
                    <input type="text" name="country" value="{{ $client->country }}" class="form-control" placeholder="Country">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">State</label>
                    <input type="text" name="state" value="{{ $client->state }}" class="form-control" placeholder="State">
                  </div> 
                </div>
                <div class="card-footer" align='right'>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div
          </div>
         
</section>

@endsection