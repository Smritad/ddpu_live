<!doctype html>
<html lang="en">

<head>
@include('components.backend.head')

<style>

.preview-box{
    position:relative;
    display:inline-block;
    margin-top:10px;
    overflow:hidden;
}

.preview-box img{
    max-height:200px;
    border:1px solid #ddd;
    padding:5px;
    border-radius:6px;
}

.remove-img{
    position:absolute;
    top:6px;
    right:6px;
    width:26px;
    height:26px;
    background:red;
    color:#fff;
    font-size:18px;
    text-align:center;
    border-radius:50%;
    cursor:pointer;
    line-height:24px;
    font-weight:bold;
    z-index:5;
}

.icon-preview{
    max-height:60px;
    display:block;
    margin-top:5px;
    border-radius:5px;
    border:1px solid #ddd;
}

.section-title{
    margin-top:30px;
    margin-bottom:15px;
    font-weight:600;
    border-bottom:1px solid #ddd;
    padding-bottom:5px;
}

</style>
</head>

<body>

@include('components.backend.header')
@include('components.backend.sidebar')

<div class="page-body">
<div class="container-fluid">

<!-- Page Title -->
<div class="row mb-3">

<div class="col-6">
<h4>Edit Our Method Details</h4>
</div>

<div class="col-6 text-end">
<ol class="breadcrumb">
<li class="breadcrumb-item">
<a href="{{ route('our-methods.index') }}">Home</a>
</li>
<li class="breadcrumb-item active">Edit Our Method</li>
</ol>
</div>

</div>


<div class="card shadow-sm">

<div class="card-header">
<h5 class="mb-0">Edit Our Method Form</h5>
<p class="text-muted mb-0">Update details and submit the form.</p>
</div>


<div class="card-body">

<form class="row g-3"
action="{{ route('our-methods.update',$ourMethod->id) }}"
method="POST"
enctype="multipart/form-data">

@csrf
@method('PUT')


<!-- Banner -->
<h5 class="section-title">Banner Section</h5>

<div class="col-md-12">

<label class="form-label fw-semibold">
Banner Image <span class="text-danger">*</span>
</label>

<input type="file"
name="banner_image"
class="form-control"
accept="image/*"
onchange="previewBanner(this)">

</div>


<div class="col-md-12"
id="bannerPreviewBox"
style="display:{{ $ourMethod->banner_image ? 'block' : 'none' }}">

<div class="preview-box">

<span class="remove-img"
onclick="removeBanner()">×</span>

<img id="bannerPreview"
src="{{ asset('uploads/our-method/'.$ourMethod->banner_image) }}"
class="img-fluid">

</div>

</div>



<!-- Strategic -->
<h5 class="section-title">Strategic Section</h5>

<div class="col-md-6">

<label class="form-label fw-semibold">
Strategic Title
</label>

<input type="text"
name="strategic_title"
class="form-control"
value="{{ old('strategic_title',$ourMethod->strategic_title) }}">

</div>


<div class="col-md-6">

<label class="form-label fw-semibold">
Strategic Image
</label>

<input type="file"
name="strategic_image"
class="form-control"
onchange="previewStrategic(this)">

</div>


<div class="col-md-12">

<label class="form-label fw-semibold">
Strategic Description
</label>

<textarea name="strategic_description"
class="form-control"
rows="3">{{ old('strategic_description',$ourMethod->strategic_description) }}</textarea>

</div>


<div class="col-md-12"
id="strategicPreviewBox"
style="display:{{ $ourMethod->strategic_image ? 'block':'none' }}">

<div class="preview-box">

<span class="remove-img"
onclick="removeStrategic()">×</span>

<img id="strategicPreview"
src="{{ asset('uploads/our-method/'.$ourMethod->strategic_image) }}"
class="img-fluid">

</div>

</div>



<!-- Strategic Elements -->
<h5 class="section-title">Strategic Elements</h5>

<div class="col-md-6">

<label class="form-label fw-semibold">
Strategic Elements Title
</label>

<input type="text"
name="strategic_elements_title"
class="form-control"
value="{{ old('strategic_elements_title',$ourMethod->strategic_elements_title) }}">

</div>


<div class="col-md-12 d-flex justify-content-end mb-2">

<button type="button"
class="btn btn-primary btn-sm"
onclick="addRow()">
+ Add More
</button>

</div>



<div class="col-md-12 table-responsive">

<table class="table table-bordered"
id="strategicTable">

<thead class="table-light">
<tr>
<th>Icon</th>
<th>Title</th>
<th>Description</th>
<th width="80">Action</th>
</tr>
</thead>

<tbody>

@forelse($elements as $key => $el)

<tr>

<td>

<input type="file"
name="elements[{{ $key }}][icon]"
class="form-control"
onchange="previewIcon(this)">

<img class="icon-preview mt-2"
src="{{ !empty($el['icon']) ? asset('uploads/our-method/elements/'.$el['icon']) : '' }}">

</td>


<td>
<input type="text"
name="elements[{{ $key }}][title]"
class="form-control"
value="{{ $el['title'] ?? '' }}">
</td>


<td>
<textarea name="elements[{{ $key }}][description]"
class="form-control editor"
rows="2">{{ $el['description'] ?? '' }}</textarea>
</td>


<td>
<button type="button"
class="btn btn-danger btn-sm"
onclick="removeRow(this)">
×
</button>
</td>

</tr>

@empty

<tr>

<td>

<input type="file"
name="elements[0][icon]"
class="form-control"
onchange="previewIcon(this)">

<img class="icon-preview mt-2"
style="display:none">

</td>

<td>
<input type="text"
name="elements[0][title]"
class="form-control">
</td>

<td>
<textarea name="elements[0][description]"
class="form-control editor"
rows="2"></textarea>
</td>

<td>
<button type="button"
class="btn btn-danger btn-sm"
onclick="removeRow(this)">
×
</button>
</td>

</tr>

@endforelse

</tbody>

</table>

</div>



<div class="col-12 text-end mt-3">

<button type="submit"
class="btn btn-success px-4">
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

let rowIndex = {{ count($elements ?? []) }};

/* Banner Preview */
function previewBanner(input){
if(input.files[0]){
document.getElementById('bannerPreview').src = URL.createObjectURL(input.files[0]);
document.getElementById('bannerPreviewBox').style.display='block';
}
}

function removeBanner(){
document.querySelector('[name="banner_image"]').value='';
document.getElementById('bannerPreviewBox').style.display='none';
}


/* Strategic Preview */
function previewStrategic(input){
if(input.files[0]){
document.getElementById('strategicPreview').src = URL.createObjectURL(input.files[0]);
document.getElementById('strategicPreviewBox').style.display='block';
}
}

function removeStrategic(){
document.querySelector('[name="strategic_image"]').value='';
document.getElementById('strategicPreviewBox').style.display='none';
}


/* Icon Preview */
function previewIcon(input){
const img=input.nextElementSibling;
if(input.files[0]){
img.src=URL.createObjectURL(input.files[0]);
img.style.display='block';
}
}


/* Add Row */
function addRow(){

const table=document.querySelector('#strategicTable tbody');

const row=`
<tr>

<td>
<input type="file"
name="elements[${rowIndex}][icon]"
class="form-control"
onchange="previewIcon(this)">

<img class="icon-preview mt-2"
style="display:none">
</td>

<td>
<input type="text"
name="elements[${rowIndex}][title]"
class="form-control">
</td>

<td>
<textarea name="elements[${rowIndex}][description]"
class="form-control editor"
rows="2"></textarea>
</td>

<td>
<button type="button"
class="btn btn-danger btn-sm"
onclick="removeRow(this)">×</button>
</td>

</tr>`;

table.insertAdjacentHTML('beforeend',row);

rowIndex++;

}

function removeRow(btn){
btn.closest('tr').remove();
}

</script>

</body>
</html>