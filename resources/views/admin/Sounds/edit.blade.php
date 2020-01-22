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
              <!-- /.card-header -->
              <!-- form start -->
             <form role="form" action="{{ route('sounds.update', $sound->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <input type="hidden" name="_method" value="put">
                <div class="row"> 
                  <div class="form-group col-md-6">
                    <input type="hidden" name="c_id" value="{{ $sound->client_id }}">
                    <label for="exampleInputEmail1">Client</label> 
                    <select class="form-control" name="client_id" disabled="disabled"> 
                      <option value="" selected>Select Client</option>
                      @foreach ($clients as $client) 
                      <option value="{{ $client->id }}" {{ $client->id == $sound->client_id ? 'selected' : ''}}>{{ $client->id.'-'.$client->fname.' '.$client->lname }}</option>
                      @endforeach
                    </select>
                    @error('client_id')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">

                    <label for="exampleInputPassword1">Sound File</label>
                    <input type="text" name="title" value="{{ $sound->title }}" class="form-control" placeholder="Sound File">
                    @error('title')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="row"> 
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Status</label> 
                    <select class="form-control" name="status"> 
                      <option value="" selected>Status</option> 
                      <option value="Active" {{ $sound->status == 'Active' ? 'selected' : ''}}>Active</option>
                      <option value="Pending" {{ $sound->status == 'Pending' ? 'selected' : ''}}>Pending</option>
              
                    </select>
                    @error('status')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                   
                </div>  
                <!-- <div class="row">
                  <div class="form-group col-md-6">
                     <label for="exampleInputPassword1">Choose file</label>
                    <div class="custom-file">
                        <label class="custom-file-label"></label>
                        <input type="file" name="image" value="{{ $sound->image }}" class="custom-file-input" id="exampleInputFile">
                        <input type="hidden" name="hidden_image" value="{{ $sound->image }}" />
                       @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                      </div>
                  </div>
                    <div class="form-group col-md-6">
                        <audio controls> 
                            <source src="{{ URL::asset('images/'.$sound->original_name) }}" type="audio/mpeg"> 
                        </audio>
                    </div> 
                </div> -->
                 
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