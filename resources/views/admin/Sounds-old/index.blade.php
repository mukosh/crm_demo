@extends('admin.template.layout')

@section('content') 
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Sound</h1>
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
      <div class="container-fluid">
         
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sound Listing</h3>

                <div class="card-tools">
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ route('sounds.create') }}">Create New Sound</a>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Sound File</th> 
                      <th>Audio</th>
                      <th>Created</th> 
                      <th colspan="3">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($sounds as $sound)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $sound->title }}</td> 
                        <td><audio controls> 
                              <source src="{{ URL::asset('images/'.$sound->original_name) }}" type="audio/mpeg"> 
                            </audio>
                        </td>
                        <td>{{ $sound->created_at->format('jS F Y') }}</td>
                        
                        <td>
                            <form action="{{ route('sounds.destroy', $sound->id) }}" method="POST">
                                <!-- <a class="btn btn-info" href="">Show</a> -->
                                <a class="btn btn-primary" href="{{ route('sounds.edit', $sound->id) }}">Edit</a>
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/> 
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                     
                  </tbody>
                </table>
              </div>
                {!! $sounds->links() !!}
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
   
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
  <!-- /.content-wrapper -->
    
    

     
@endsection