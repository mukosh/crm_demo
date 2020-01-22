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
            <h1 class="m-0 text-dark">Recharge History</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Recharge History</li>
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
              <h3 class="card-title">Recharge History</h3> 
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
                    <th>Client Id</th>
                    <th>Client Name</th>
                    <th>Amount</th>
                    <th>Balance</th> 
                    <th>Created</th> 
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 
                  @foreach ($recharge as $row)
                    <tr> 
                      <td><a href="#" class="viewclient" data-toggle="modal" data-id="{{ $row->client_id }}" data-target="#viewclient">{{ $row->client_id }}</a></td>
                      <td>{{ $row->fname.' '.$row->lname }}</td>
                      <td>{{ $row->amount }}</td>
                      <td>{{ $row->balance }}</td>
                      <td>{{ $row->created_at }}</td> 
                      <td><button type="button" class="btn btn-info view" data-toggle="modal" data-id="{{ $row->id }}" data-target="#view">Show</button></td>
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

 <div id="view" class="modal fade" role="dialog">
  <div class="modal-dialog">  
    <table class="responstable"> 
      <tr>
        <th>Client Name</th>
        <th>Amount</th> 
      </tr>       
      <tr>
        <td><p id="name"></p></td>
        <td><p id="amount"></p></td> 
      </tr> 
      <tr>
        <th>Balance</th>
        <th>Created</th> 
      </tr>       
      <tr>
        <td><p id="balance"></p></td>
        <td><p id="created_at"></p></td> 
      </tr> 
      <tr>
        <th>Description</th> 
      </tr> 
      <tr>
        <td><p id="description"></p></td> 
      </tr> 
    </table> 
  </div>
</div>

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
    <td><p id="client_name"></p></td>
    <td><p id="client_email"></p></td>
    <td><p id="client_company"></p></td>
    <td><p id="client_phone"></p></td>
    <td><p id="client_description"></p></td>
  </tr>
  
  <tr>
    <th>Address</th>
    <th>Pin code</th>
    <th>Call Limit</th>
    <th>Pacing</th>
    <th>Balance</th>
  </tr>       
  <tr>
    <td><p id="client_address"></p></td>
    <td><p id="client_pincode"></p></td>
    <td><p id="client_call_limit"></p></td>
    <td><p id="client_pacing"></p></td>
    <td><p id="client_balance"></p></td>
  </tr>
  
  <tr>
    <th>Country</th>
    <th>State</th>
    <th>City</th>
    <th>Status</th>
    <th>Created</th>
  </tr> 
  <tr>
    <td><p id="client_country"></p></td>
    <td><p id="client_state"></p></td>
    <td><p id="client_city"></p></td>
    <td><p id="client_status"></p></td>
    <td><p id="client_created_at"></p></td>
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
        $('.view').on('click',function(){
          var id = $(this).attr("data-id"); 
          $.ajax({
              type: "POST",
              url: '{{url("recharge/view")}}'+'?_token=' + '{{ csrf_token() }}',
              data: {id: id}, 
              dataType: "json",
              cache: false,
              success: function(result) {  
                console.log(result);
                 $('#name').text(result[0].fname+' '+result[0].lname);
                 $('#balance').text(result[0].balance);
                 $('#amount').text(result[0].amount);
                 $('#created_at').text(result[0].created_at);
                 $('#description').text(result[0].description); 
              } 
          });   
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
                $('#client_name').text(result[0].fname+' '+result[0].lname);
                $('#client_email').text(result[0].email);
                $('#client_company').text(result[0].company);
                $('#client_phone').text(result[0].phone);
                $('#client_description').text(result[0].description);
                $('#client_address').text(result[0].address);
                $('#client_pincode').text(result[0].pincode);
                $('#client_call_limit').text(result[0].call_limit);
                $('#client_pacing').text(result[0].pacing);
                $('#client_city').text(result[0].city);
                $('#client_country').text(result[0].country);
                $('#client_state').text(result[0].state);
                $('#client_balance').text(result[0].balance);
                $('#client_status').text(result[0].status);
                $('#client_created_at').text(result[0].created_at); 
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