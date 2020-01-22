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
            <h1 class="m-0 text-dark">Edit Callers</h1>
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
                <h3 class="card-title">Edit Callers</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start --> 
                <form action="{{ route('callers.update', $caller->id) }}" method="POST">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="put">
                    <div class="row"> 


                    <div class="form-group col-md-6"> 
                      <label for="exampleInputPassword1">Client</label>
                      <select id="position" name="client_id" class="form-control">
                        <option value=""></option>
                        @foreach ($clients as $client) 
                          <option value="{{ $client->id }}"  {{ $caller->client_id == $client->id ? 'selected' : ''}}>{{ $client->id.'-'.$client->fname.' '.$client->lname }}</option>
                        @endforeach
                      </select>
                      @error('client_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputPassword1">Callers ID</label>
                      <input type="text" name="caller_id" value="{{ $caller->caller_id }}" class="form-control" placeholder="Callers ID">
                      @error('caller')
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<script type="text/javascript">
  $("#position").select2({
   allowClear:true,
   placeholder: 'Position'
 });
</script>
@endsection