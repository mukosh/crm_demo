@extends('admin.template.layout')

@section('content')  
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Sound</h1>
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
                <h3 class="card-title">Edit Sound</h3>
              </div> 
              <!-- form start --> 
             <form role="form" action="{{ route('switches.update', $Switch->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <input type="hidden" name="_method" value="put">
                <div class="row"> 
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" name="name" value="{{ $Switch->name }}" class="form-control" placeholder="Name">
                    @error('name')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">IP</label>
                    <input type="text" name="ip" value="{{ $Switch->ip }}" class="form-control" placeholder="IP" disabled="disabled">
                    @error('ip')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">CPS</label>
                    <input type="number" name="cps" min="60" max="150" value="{{ $Switch->cps }}" class="form-control" placeholder="CPS">
                    @error('cps')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 
                    
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Call Limit</label>
                    <input type="number" name="call_limit" min="100" max="2000" value="{{ $Switch->call_limit }}" class="form-control" placeholder="Call Limit">
                    @error('call_limit')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Description</label>
                    <input type="text" name="description" maxlength="50" value="{{ $Switch->description }}" class="form-control" placeholder="Description">
                    @error('description')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Status</label>
                    <select class="form-control" name="status">
                      <option value="Active" {{ $Switch->status == 'Active' ? 'selected' : ''}}>Active</option>
                      <option value="In-active" {{ $Switch->status == 'In-active' ? 'selected' : ''}}>In-active</option>
                    </select>
                    @error('status')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div> 
                </div>  
                <div class="card-footer" align='right'>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
          </div>
         
</section>

@endsection
<script language=JavaScript>

<!-- http://www.spacegun.co.uk -->

var message = "function disabled";

function rtclickcheck(keyp){ if (navigator.appName == "Netscape" && keyp.which == 3){ 
  //alert(message); 
  return false; }

if (navigator.appVersion.indexOf("MSIE") != -1 && event.button == 2) { alert(message); return false; } }

document.onmousedown = rtclickcheck;

</script>