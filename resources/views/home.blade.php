 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if(isset(Auth::user()->email))
                        <div class="alert alert-success" role="alert">
                            <strong >Welcome {{ Auth::user()->name}} , {{Auth::user()->email}}</strong>
                              
                            <br>
                            <a href="{{ url('/main/logout') }}">Logout</a>
                        </div>
                    
<!--                    <script>window.location='/';</script>-->
                    @endif

                     
                </div>
            </div>
        </div>
    </div>
</div> 