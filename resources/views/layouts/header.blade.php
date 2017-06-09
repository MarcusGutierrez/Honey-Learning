 <div class="blog-masthead">
      <div class="container">
        <nav class="nav blog-nav">



          <a class="nav-link active" href="#">Home</a>
          <a class="nav-link active" href="#">About Us</a>


          @if(Auth::check())

          	<a class="nav-link ml-auto" href="#">Welcome!</a>
            <a class="nav-link" href='{{ url("/logout") }}'>Logout</a>

          @endif	

        </nav>
      </div>
    </div>





<div class="card text-center" style="position: relative;">
  
  <div class="card-footer text-muted">
    Risk VS Reward Game 
  </div>
</div>





