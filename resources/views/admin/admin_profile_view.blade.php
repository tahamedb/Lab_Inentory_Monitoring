@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

        
        <div class="row profile-body">
          <!-- left wrapper start -->
          <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
            <div class="card rounded">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <h6 class="card-title mb-0">About</h6>
                 
                </div>
                <div>
                <img class="rounded-circle" src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}" alt="profile" style="object-fit: cover;width: 100px; height: 100px">
                    <span class="h4 ms-3 ">{{$profileData->name}}</span>
                  </div>
                <div class="mt-3">
                  <label class="tx-11 fw-bolder mb-0 text-uppercase">Joined:</label>
                  <p class="text-muted">{{$profileData->created_at}}</p>
                </div>
                <div class="mt-3">
                 
                <div class="mt-3">
                  <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                  <p class="text-muted">{{$profileData->email}}</p>
                </div>
    
                <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                    <i data-feather="twitter"></i>
                  </a>
                  <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                    <i data-feather="instagram"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <!-- left wrapper end -->
          <!-- middle wrapper start -->
          <div class="col-md-8 col-xl-8 middle-wrapper">
          <div class="card">
              <div class="card-body">

								<h6 class="card-title">Update Profile</h6>

                <form method="POST" class="forms-sample" action="{{ route('admin.profile.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="exampleInputUsername1" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" id="exampleInputUsername1" placeholder="Username" autocomplete="off" value="{{ $profileData->name }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="{{ $profileData->email }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" autocomplete="off" placeholder="Password">
    </div>
    <div class="mb-3">
        <label class="form-label" for="formFile">File upload</label>
        <input class="form-control" type="file" name="photo" id="image">
    </div>
    <img id="showImage" class="wd-70 rounded-circle " src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}" alt="profile" style="object-fit: cover;width: 100px; height: 100px">
    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">
            Remember me
        </label>
    </div>
    <button type="submit" class="btn btn-primary me-2">Save changes</button>
    <button class="btn btn-secondary">Cancel</button>
</form>


              </div>
            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->
         
          <!-- right wrapper end -->
        </div>

			</div>

            <script type="text/javascript">
$(document).ready(function(){
  $('#image').change(function(e){ // Assuming 'image' is the ID of your file input
    var reader = new FileReader();
    reader.onload = function(e){
      $('#showImage').attr('src', e.target.result);
    };
    reader.readAsDataURL(e.target.files[0]); // Removed the quotes around 0
  });
});
</script>


@endsection