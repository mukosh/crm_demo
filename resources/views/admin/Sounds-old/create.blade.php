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
                <h3 class="card-title">Add Sound</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <form role="form" action="{{ route('sounds.store') }}" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="row">
                  
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Campaign</label> 
                    <select class="form-control" name="campaign"> 
                      <option value="1">Campaign 1</option>
                      <option value="2">Campaign 2</option>
                      <option value="3">Campaign 3</option>
                      <option value="4">Campaign 4</option>
                      <option value="5">Campaign 5</option>
                    </select>
                    @error('campaign')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Sound File</label>
                    <input type="text" name="title" value="{{ old('title')}}" class="form-control" placeholder="Sound File">
                    @error('title')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>  
                <div class="row">
                  <div class="form-group col-md-6">
                     <label for="exampleInputPassword1">Choose file</label>
                    <div class="custom-file">
                        <label class="custom-file-label"></label>
                        <input type="file" name="image" value="{{ old('image') }}" class="custom-file-input" id="exampleInputFile">
                       @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                      </div>
                  </div>
                  
                  
                </div>
                 
                <div class="card-footer" align='right'>
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div
          </div>
         
</section>

@endsection