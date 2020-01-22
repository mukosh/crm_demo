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
            <h1 class="m-0 text-dark">Log History</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Logs</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12"> 
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Log Details</h3> 
            </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block"> 
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong> {{ $message }} </strong>
                    </div>
                @endif
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>  
                    <th>Id</th>
                    <th>Name</th>
                    <th>Module</th>
                    <th>Activity</th> 
                    <th>IP Address</th> 
                    <th>Created</th> 
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $row)
                     <tr>
                      <td>{{ $row->id }}</td>
                      <td>{{ $row->fname.' '.$row->lname }}</td>
                      <td>{{ $row->module_name }}</td>
                      <td>{{ $row->activity }}</td>
                      <td>{{ $row->ip_address }}</td>
                      <td>{{ $row->created_at }}</td> 
                      <td><button type="button" class="btn btn-info viewlog" data-toggle="modal" data-id="{{ $row->id }}" data-target="#viewlog">Show</button></td> 
                    </tr>
                    @endforeach
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
 <!-- Modal -->  

 <div id="viewlog" class="modal fade" role="dialog">
  <div class="modal-dialog">  
    <table class="responstable"> 
      <tr>
        <th>Client Name</th>
        <th>Module</th> 
      </tr>       
      <tr>
        <td><p id="name"></p></td>
        <td><p id="module_name"></p></td> 
      </tr> 
      <tr>
        <th>Activity</th>
        <th>IP Address</th> 
      </tr>       
      <tr>
        <td><p id="activity"></p></td>
        <td><p id="ip_address"></p></td> 
      </tr> 
      <tr>
        <th>Browser Name</th>
        <th>System Name</th> 
      </tr>       
      <tr>
        <td><p id="browser_name"></p></td>
        <td><p id="system_name"></p></td> 
      </tr>
      <tr>
        <th>Type</th>
        <th>Created</th> 
      </tr>       
      <tr>
        <td><p id="type"></p></td>
        <td><p id="created_at"></p></td> 
      </tr>
      <tr>
        <th>Data</th> 
      </tr> 
      <tr>
        <td><p id="data"></p></td> 
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
        $('.viewlog').on('click',function(){
          var id = $(this).attr("data-id"); 
          $.ajax({
              type: "POST",
              url: '{{url("logs/view")}}'+'?_token=' + '{{ csrf_token() }}',
              data: {id: id}, 
              dataType: "json",
              cache: false,
              success: function(result) {  
                console.log(result);
                  $('#name').text(result[0].fname+' '+result[0].lname);
                  $('#module_name').text(result[0].module_name);
                  $('#activity').text(result[0].activity);
                  $('#ip_address').text(result[0].ip_address);
                  $('#browser_name').text(result[0].browser_name); 
                  $('#system_name').text(result[0].system_name); 
                  $('#type').text(result[0].type); 
                  //$('#created_at').text(result[0].created_at);
                  var nowDate = (result[0].created_at);
                  var dd = moment(nowDate).format('MMM, DD YYYY hh:mm A');
                  //alert(dd);
                  $('#created_at').text(dd);
                  $('#data').text(result[0].data);
              } 
          });   
      });
      });
</script>
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