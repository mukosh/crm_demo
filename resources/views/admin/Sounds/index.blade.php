@extends('admin.template.layout')

@section('content') 
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
              <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Sound</li>
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
                        <a class="btn btn-success" href="{{ route('sounds.create') }}">Add Sound</a>
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
                      <th>Client ID</th>
                      <th>Sound File</th> 
                      <th>Audio</th>
                      <th>Status</th>
                      <th>Created</th> 
                      <th colspan="3">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($sounds as $sound)
                    <tr>
                        <td><a href="#" class="viewclient" data-toggle="modal" data-id="{{ $sound['c_id'] }}" data-target="#viewclient">{{ $sound['c_id'] }}</a></td>
                        
                        <td>{{ $sound->title }}</td> 
                        <td>
                            <audio controls> 
                              <source src="{{ URL::asset('public/images/'.$sound->original_name) }}" type="audio/mpeg"> 
                            </audio>
                        </td>
                        <td>{{ $sound->status }}</td>
                        <td>{{ $sound->created_at->format('jS F Y') }}</td>
                        
                        <td>
                            <form action="{{ route('sounds.destroy', $sound->id) }}" method="POST">
                                <!-- <a class="btn btn-info" href="">Show</a> -->
                                <a class="btn btn-primary" href="{{ route('sounds.edit', $sound->id) }}">Edit</a>
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/> 
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</button>
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
    
    <!-- client view --> 
<div id="viewclient" class="modal fade" role="dialog">
  <div class="modal-dialog">
       
<table class="responstable"> 
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone Number</th>
    <th>Company Name</th>
    <th>Description</th>
  </tr>       
  <tr>
    <td><p id="name"></p></td>
    <td><p id="email"></p></td>
    <td><p id="company"></p></td>
    <td><p id="phone"></p></td>
    <td><p id="description"></p></td>
  </tr>
  
  <tr>
    <th>Address</th>
    <th>Pin code</th>
    <th>Call Limit</th>
    <th>Pacing</th>
    <th>Balance</th>
  </tr>       
  <tr>
    <td><p id="address"></p></td>
    <td><p id="pincode"></p></td>
    <td><p id="call_limit"></p></td>
    <td><p id="pacing"></p></td>
    <td><p id="balance"></p></td>
  </tr>
  
  <tr>
    <th>Country</th>
    <th>State</th>
    <th>City</th>
    <th>Status</th>
    <th>Created</th>
  </tr> 
  <tr>
    <td><p id="country"></p></td>
    <td><p id="state"></p></td>
    <td><p id="city"></p></td>
    <td><p id="status"></p></td>
    <td><p id="created_at"></p></td>
  </tr>
  
</table>

  </div>
</div>  

     
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<script type="text/javascript"> 
  $( document ).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      }); 
      $('.viewclient').on('click',function(){
      var clientId = $(this).attr("data-id"); 
      $.ajax({
              type: "POST",
              url: '{{url("clients/viewclient")}}'+'?_token=' + '{{ csrf_token() }}',
              data: {clientId: clientId}, 
              dataType: "json",
              cache: false,
              success: function(result) {  
                $('#name').text(result[0].fname+' '+result[0].lname);
                $('#email').text(result[0].email);
                $('#company').text(result[0].company);
                $('#phone').text(result[0].phone);
                $('#description').text(result[0].description);
                $('#address').text(result[0].address);
                $('#pincode').text(result[0].pincode);
                $('#call_limit').text(result[0].call_limit);
                $('#pacing').text(result[0].pacing);
                $('#city').text(result[0].city);
                $('#country').text(result[0].country);
                $('#state').text(result[0].state);
                $('#balance').text(result[0].balance);
                $('#status').text(result[0].status);
                $('#created_at').text(result[0].created_at); 
              } 
          });   
      });
  });
</script>
<style type="text/css">
  .error-msg{
   background-color: #FF0000;
}
</style>
<style type="text/css"> 
.responstable {
  margin: 5em 0;
  width: 180%;
  margin: 130px 82px 0px -176px;
  overflow: hidden;
  background: #FFF;
  color: #024457;
  border-radius: 10px;
  border: 1px solid #167F92;
}
.responstable tr {
  border: 1px solid #D9E4E6;
}
.responstable tr:nth-child(odd) {
  background-color: #EAF3F3;
}
.responstable th {
  display: none;
  border: 1px solid #FFF;
  background-color: #167F92;
  color: #FFF;
  padding: 1em;
}
.responstable th:first-child {
  display: table-cell;
  text-align: center;
}
.responstable th:nth-child(2) {
  display: table-cell;
}
.responstable th:nth-child(2) span {
  display: none;
}
.responstable th:nth-child(2):after {
  content: attr(data-th);
}
@media (min-width: 480px) {
  .responstable th:nth-child(2) span {
    display: block;
  }
  .responstable th:nth-child(2):after {
    display: none;
  }
}
.responstable td {
  display: block;
  word-wrap: break-word;
  max-width: 7em;
}
.responstable td:first-child {
  display: table-cell;
  text-align: center;
  border-right: 1px solid #D9E4E6;
}
@media (min-width: 480px) {
  .responstable td {
    border: 1px solid #D9E4E6;
  }
}
.responstable th, .responstable td {
  text-align: left;
  margin: .5em 1em;
}
@media (min-width: 480px) {
  .responstable th, .responstable td {
    display: table-cell;
    padding: 1em;
  }
}

body {
  padding: 0 2em;
  font-family: Arial, sans-serif;
  color: #024457;
  background: #f2f2f2;
}

h1 {
  font-family: Verdana;
  font-weight: normal;
  color: #024457;
}
h1 span {
  color: #167F92;
}

</style>