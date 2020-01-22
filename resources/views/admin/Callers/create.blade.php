@extends('admin.template.layout')

@section('content')  
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Callers</h1>
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
                <h3 class="card-title">Add Callers</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <form id ="myForm" role="form" action="{{url('caller/callercreateajax')}}" data-toggle="modal" method="POST">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="row"> 
                  <div class="form-group col-md-6"> 
                    <label for="exampleInputPassword1">Client</label>
                    <select id="position" name="client_id" id="client_id" class="form-control">
                      <option value="">Select Client</option>
                      @foreach ($clients as $client) 
                        <option value="{{ $client->id }}">{{ $client->id.'-'.$client->fname.' '.$client->lname }}</option>
                      @endforeach
                    </select> 
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Callers ID </label>
                    <input type="text" name="caller" id="caller" value="{{ old('caller') }}" class="form-control" placeholder="Callers ID"> 
                  </div>
                </div>  
                <div class="card-footer" align='right'>
                  <button type="submit" class="btn btn-warning cverify" >Verify</button> 
                </div>
              </form>
            </div>
          </div>
         
</section>
<div id="myModal" class="modal fade" role="dialog"> 
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Caller Id Verification</h4>
         <p id="success_msg" style="color:green;"></p>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body"> 
        <form class="col s12" method="post" id="submit" action="{{url('caller/calleridverifyajax')}}">
           <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
          <div class="row">
           
            <div class="col">
               <label>OTP</label>
              <input type="text" name="otp" class="form-control" id="otp" placeholder="Enter your otp">
            </div> 
          </div><br>
           
          <div class="row" align="center">
            <div class="col">
              <button class="btn btn-primary verifycallerid" type="submit">Submit</button>
            </div>
          </div>
        </form>
      </div> 
    </div>

  </div>
</div>
 
<script type="text/javascript">
  $("#position").select2({
    allowClear:true,
    placeholder: 'Position'
  });
</script>
<script type="text/javascript"> 
  $( document ).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      }); 
      $.validator.addMethod("alphabetsnspace", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
      });
      $.validator.addMethod("pnum", function(value, element) {
          return this.optional(element) || /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/.test(value);
      }); 
      $("#myForm").validate({ 
          rules: { 
            client_id:{
              required: true, 
            },
            caller: {                
              required: true,  
              pnum: true,              
              remote: {                   
                  url: '{{url("checkCallerId")}}'+'?_token=' + '{{ csrf_token() }}', 
                  type: "POST",                    
                  data: {  
                      caller: function() {
                        return $( "#caller" ).val();
                      }
                    }                   
                }         
            }, 
          },
          //For custom messages
          messages: {  
            client_id: {
              required: "client is required", 
            },
            caller: {
              required: "Please enter a caller Id",
              pnum: "Please enter only number"                
              //remote: "The caller Id you entered is already used" 
            },  
          },
          errorElement: 'div',
          errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
              $(placement).append(error)
            } else {
              error.insertAfter(element);
            }
          },
          submitHandler: function(form) { 
           $.ajax({ 
                url:form.action,
                type:form.method,
                data:$(form).serialize(), 
                success: function(res){
                  $('.cverify').remove();
                  $('#myModal').modal('show');
             }
           }); 
        } 
    });  
      $("#submit").validate({ 
          rules: { 
            otp:{
              required: true,
              pnum: true,
            },  
          }, 
          messages: {  
            otp: {
              required: "Enter your OTP",
              pnum: "Please enter only number"
            },  
          },
          errorElement: 'div',
          errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
              $(placement).append(error)
            } else {
              error.insertAfter(element);
            }
          },
          submitHandler: function(form) { 
          $.ajax({ 
              url:form.action,
              type:form.method,
              data:$(form).serialize(), 
              success: function(data){
                $("#success_msg").html(data);
                var msg = window.setTimeout(function(){location.reload()},2000);
                if(msg){
                 window.location.replace('{{url("callers")}}');
                }
              }
          }); 
        } 
    }); 
  });
</script>

@endsection