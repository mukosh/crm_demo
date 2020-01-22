@extends('admin.template.layout')

@section('content')  
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Phone Books</h1>
          </div><!-- /.col --> 
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <!--   @if ( Session::has('duplicate') )
        <div class="alert alert-primary alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('duplicate') }}</strong>
        </div>
      @endif -->

      @if ( Session::has('success') )
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <strong>{{ Session::get('success') }}</strong>
        </div>
      @endif

      @if ( Session::has('error') )
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('error') }}</strong>
        </div>
      @endif

      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <div>
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
          </div>
        </div>
      @endif
    <section class="content">
       
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Phonebook</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <form role="form" action="{{ route('phonebooks.store') }}" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="row"> 
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Client</label> 
                    <select class="form-control" name="client"> 
                        <option value="">Select Client</option>
                        @foreach($clients as $user_row)
                          <option value="{{ $user_row->id }}" {{ old("client") == $user_row->id ? 'selected' : '' }}>{{ $user_row->id.' - '. $user_row->fname.' '.$user_row->lname }}</option>
                        @endforeach  
                    </select> 
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Phonebook Name</label>
                    <input type="text" name="phonebook" value="{{ $phonbook }}" class="form-control" placeholder="Phone Book">
                    @error('phonebook')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>  
                <div class="row"> 
                  <div class="form-group col-md-6">
                     <label for="exampleInputPassword1">Upload Contact</label>
                    <div class="custom-file">
                        <label class="custom-file-label"></label>
                        <input type="file" name="file" value="{{ old('file') }}" class="custom-file-input" id="exampleInputFile">
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
            </div>
          </div>
         
</section>

@endsection