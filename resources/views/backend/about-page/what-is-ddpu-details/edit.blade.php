<!doctype html>
<html lang="en">
<head>
@include('components.backend.head')

<style>

/* FIX IMAGE CONTAINERS */
.image-box{
position:relative;
display:inline-block;
overflow:hidden;
}

/* FIX REMOVE BUTTON */
.remove-btn{
position:absolute;
top:5px;
right:5px;
width:26px;
height:26px;
background:red;
color:#fff;
border-radius:50%;
text-align:center;
line-height:24px;
font-size:18px;
cursor:pointer;
z-index:5;
}

</style>

</head>

<body>

@include('components.backend.header')
@include('components.backend.sidebar')

<div class="page-body">
<div class="container-fluid">

<!-- PAGE TITLE -->
<div class="page-title">
<div class="row">

<div class="col-6">
<h4>Edit DDPU Details Form</h4>
</div>

<div class="col-6">
<ol class="breadcrumb">
<li class="breadcrumb-item">
<a href="{{ route('what-is-ddpu-details.index') }}">Home</a>
</li>
<li class="breadcrumb-item active">Edit DDPU Details</li>
</ol>
</div>

</div>
</div>


<!-- CARD -->
<div class="card mt-3">

<div class="card-header">
<h4>DDPU Details Form</h4>
<p class="f-m-light mt-1">Update the details and submit the form.</p>
</div>


<div class="card-body">

<form method="POST"
action="{{ route('what-is-ddpu-details.update',$ddpu->id) }}"
enctype="multipart/form-data"
class="row g-4">

@csrf
@method('PUT')


<!-- BANNER IMAGE -->
<div class="col-md-6">

<label class="form-label fw-semibold">
Banner Image <span class="txt-danger">*</span>
</label>

<input type="file"
class="form-control"
name="banner_image"
onchange="previewSingleImage(this)">


@if($ddpu->banner_image)

<div id="oldBannerContainer"
class="image-box mt-3">

<span class="remove-btn remove-old-banner">×</span>

<img src="{{ asset('whatddpu/banner/'.$ddpu->banner_image) }}"
style="max-height:200px;border:1px solid #ddd;padding:5px;">

</div>

<input type="hidden"
id="remove_old_banner"
name="remove_old_banner"
value="0">

@endif


<!-- NEW PREVIEW -->
<div id="newBannerPreview"
class="image-box mt-3"
style="display:none">

<span class="remove-btn"
onclick="removeNewBanner()">×</span>

<img id="banner_preview"
style="max-height:200px;border:1px solid #ddd;padding:5px;">

</div>

</div>



<!-- TITLE -->
<div class="col-md-6">

<label class="form-label fw-semibold">
Title<span class="txt-danger">*</span>
</label>

<input type="text"
class="form-control"
name="title"
value="{{ $ddpu->title }}"
required>

</div>



<!-- GALLERY -->
<div class="col-md-12">

<label class="form-label fw-semibold">
Gallery Images<span class="txt-danger">*</span>
</label>

<input type="file"
class="form-control"
name="gallery_images[]"
multiple
onchange="previewMultipleImages(this)">



@if($ddpu->gallery_images)

<div id="oldGalleryContainer"
class="mt-3 d-flex flex-wrap gap-3">

@foreach($ddpu->gallery_images as $i => $img)

<div id="old-gallery-item-{{ $i }}"
class="image-box">

<span class="remove-btn remove-old-gallery"
data-index="{{ $i }}">×</span>

<img src="{{ asset('whatddpu/banner/'.$img) }}"
style="max-height:150px;border:1px solid #ddd;padding:5px;">

<input type="hidden"
name="existing_gallery_images[]"
value="{{ $img }}">

</div>

@endforeach

</div>

@endif


<div id="newGalleryPreviews"
class="mt-3 d-flex flex-wrap gap-3">
</div>

</div>



<!-- DESCRIPTION -->
<div class="col-md-12">

<label class="form-label fw-semibold">
Professional Description<span class="txt-danger">*</span>
</label>

<textarea class="form-control"
id="editor"
name="professional_description"
rows="5"
required>{!! $ddpu->professional_description !!}</textarea>

</div>


<div class="col-md-12">

<label class="form-label fw-semibold">
Comparison Description<span class="txt-danger">*</span>
</label>

<textarea class="form-control"
id="editor1"
name="compare_description"
rows="5"
required>{!! $ddpu->compare_description !!}</textarea>

</div>



<!-- BUTTON -->
<div class="col-12 text-end">

<a href="{{ route('what-is-ddpu-details.index') }}"
class="btn btn-danger px-4">
Cancel
</a>

<button class="btn btn-primary px-4">
Update
</button>

</div>

</form>

</div>
</div>

</div>
</div>



@include('components.backend.footer')
@include('components.backend.main-js')


<script>

/* BANNER PREVIEW */
function previewSingleImage(input){

const reader = new FileReader();

reader.onload=function(e){

document.getElementById('banner_preview').src=e.target.result;
document.getElementById('newBannerPreview').style.display='block';

}

reader.readAsDataURL(input.files[0]);

}


/* REMOVE NEW BANNER */
function removeNewBanner(){

document.querySelector('input[name="banner_image"]').value='';
document.getElementById('newBannerPreview').style.display='none';

}


/* MULTIPLE IMAGE PREVIEW */
function previewMultipleImages(input){

const container=document.getElementById('newGalleryPreviews');

container.innerHTML='';

Array.from(input.files).forEach(file=>{

const reader=new FileReader();

reader.onload=function(e){

container.innerHTML+=`
<div class="image-box">
<img src="${e.target.result}" style="max-height:150px;border:1px solid #ddd;padding:5px;">
</div>
`;

}

reader.readAsDataURL(file);

})

}


/* REMOVE OLD IMAGES */
document.addEventListener('click',function(e){

if(e.target.classList.contains('remove-old-banner')){

document.getElementById('oldBannerContainer').remove();
document.getElementById('remove_old_banner').value=1;

}

if(e.target.classList.contains('remove-old-gallery')){

const index=e.target.dataset.index;

const el=document.getElementById('old-gallery-item-'+index);

if(el){
el.remove();
}

}

});

</script>

</body>
</html>