@extends('admin.template.layout')

@section('content')  
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Switch</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Switches</li>
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
                <h3 class="card-title">Add Switch</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <form role="form" action="{{ route('switches.store') }}" method="POST">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="row"> 
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" name="name" value="{{ old('name')}}" class="form-control" placeholder="Name">
                    @error('name')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">IP</label>
                    <input type="text" name="ip" value="{{ old('ip')}}" class="form-control" placeholder="IP">
                    @error('ip')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Ami User</label>
                    <input type="text" name="ami_user" value="{{ old('ami_user')}}" class="form-control" placeholder="Ami User">
                    @error('ami_user')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Ami Password</label>
                    <input type="Password" name="ami_password" value="{{ old('ami_password')}}" class="form-control" placeholder="Ami Password">
                    @error('ami_password')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">CPS</label>
                    <input type="number" name="cps" min="60" max="150" value="{{ old('cps')}}" class="form-control" placeholder="CPS">
                    @error('cps')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 
                    
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Call Limit</label>
                    <input type="number" name="call_limit" min="100" max="2000" value="{{ old('call_limit')}}" class="form-control" placeholder="Call Limit">
                    @error('call_limit')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Description</label>
                    <input type="text" name="description" maxlength="50" value="{{ old('description')}}" class="form-control" placeholder="Description">
                    @error('description')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Status</label>
                    <select class="form-control" name="status">
                      <option value="Active">Active</option>
                      <option value="In-active">In-active</option>
                    </select>
                    @error('status')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 
                </div>   
                <div class="card-footer" align='right'>
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div>
          </div>
         
</section>

@endsection