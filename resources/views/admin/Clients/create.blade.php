@extends('admin.template.layout')

@section('content')  


    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Client</h1>
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
                <h3 class="card-title">Add Client</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
          
             <form role="form" action="{{ route('clients.store') }}" method="POST">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">First Name*</label>
                    <input type="text" name="fname" value="{{ old('fname') }}" class="form-control" placeholder="First Name">
                    @error('fname')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Last Name</label>
                    <input type="text" name="lname" value="{{ old('lname') }}" class="form-control" placeholder="Last Name">
                    @error('lname')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div> 
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Email*</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" id="exampleInputPassword1" placeholder="Email Id">
                    @error('email')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror 
                  </div>
                  <div class="form-group col-md-6">
                    <label for="phone">Phone Number*</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" id="exampleInputPassword1" placeholder="Phone Number">
                    @error('phone')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror 
                  </div>
                </div>  
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="company">Company Name</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="form-control" placeholder="Company Name">
                    @error('company')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror 
                  </div> 
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Address*</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="form-control" placeholder="Address">
                    @error('address')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Country</label>
                    <input type="text" name="country"  value="{{ old('country') }}" class="form-control" placeholder="Country">
                    @error('country')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="state">State</label>
                    <input type="text" name="state" value="{{ old('state') }}" class="form-control" placeholder="State">
                    @error('state')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  
                </div>

                <!-- <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="pass" value="{{ old('pass') }}" class="form-control" placeholder="Password">
                    @error('pass')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="password" name="cpass" value="{{ old('cpass') }}" class="form-control" placeholder="Confirm Password">
                    @error('cpass')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 
                </div> -->
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="form-control" placeholder="City">
                    @error('city')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Pin code</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" class="form-control" placeholder="Pincode">
                    @error('pincode')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 
                </div> 
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="call_limit">Call Limit*</label>
                    <input type="number" name="call_limit" value="50" class="form-control" placeholder="Call Limit">
                    @error('call_limit')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="pacing">Pacing*</label>
                    <input type="number" name="pacing"  value="5" class="form-control" placeholder="Pacing">
                    @error('pacing')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div> 
                <div class="row"> 
                  <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                      <option value="Active">Active</option>
                      <option value="In-active">In-active</option>
                      <option value="Pending">Pending</option>
                      <option value="Suspended">Suspended</option>
                    </select>
                    @error('status')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="row"> 
                  <div class="form-group col-md-12">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea type="text" name="description" value="{{ old('description') }}" class="form-control" placeholder="Description"></textarea>
                    @error('description')
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