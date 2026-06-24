<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')

    <style>
        .remove-icon{
            position:absolute;
            top:-8px;
            right:-8px;
            background:#dc3545;
            color:#fff;
            width:22px;
            height:22px;
            border-radius:50%;
            font-size:14px;
            text-align:center;
            line-height:22px;
            cursor:pointer;
        }
    </style>
</head>

<body>

@include('components.backend.header')
@include('components.backend.sidebar')

                <div class="page-body">
                <div class="container-fluid">
                
                <!-- ================= PAGE TITLE ================= -->
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h4>Add Compare Us</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('compare-us-details.index') }}" class="btn btn-secondary btn-sm">Back</a>
                        </div>
                    </div>
                </div>
                
                <!-- ================= FORM ================= -->
                <div class="card mt-3">
                <div class="card-header">
                    <h4>Compare Us Details</h4>
                </div>
                
                <div class="card-body">
                <form action="{{ route('compare-us-details.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                
                <!-- ===== Banner ===== -->
                <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Banner Image <span class="text-danger">*</span>
                            </label>
                
                            <input type="file"
                                   class="form-control"
                                   name="banner_image"
                                   accept=".jpg,.jpeg,.png,.webp"
                                   required
                                   onchange="previewImage(this, 'bannerPreview', 'bannerSize', 'removeBannerBtn')">
                
                            <div class="position-relative d-inline-block mt-2">
                                <img id="bannerPreview"
                                     width="150"
                                     style="display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
                
                                <span id="removeBannerBtn"
                                      onclick="removeImage('banner_image','bannerPreview','bannerSize','removeBannerBtn')"
                                      style="display:none; cursor:pointer; position:absolute; top:-8px; right:-8px;
                                             background:#dc3545; color:#fff; border-radius:50%;
                                             width:22px; height:22px; text-align:center;
                                             font-size:14px; line-height:22px;">
                                    ×
                                </span>
                            </div>
                
                            <small id="bannerSize" class="text-muted d-block"></small>
                        </div>

                    <!-- ===== Heading ===== -->
                    <div class="col-md-6">
                    <label class="form-label fw-semibold">Heading *</label>
                    <input type="text" name="heading" class="form-control" required>
                    </div>
                    
                    <!-- ================= DYNAMIC TABLE ================= -->
                    <div class="col-12 mt-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Comparison Table</h5>
                    
                                <div>
                                    <button type="button" class="btn btn-success btn-sm me-2" onclick="addRow()">+ Add Row</button>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addColumn()">+ Add Column</button>
                                </div>
                            </div>
                    
                            <div class="card-body p-2">
                    
                                <!-- COLUMN INPUTS -->
                                <div class="mb-3">
                                    <label class="fw-semibold">Column Headings</label>
                                    <div id="columnInputs" class="d-flex gap-2 flex-wrap mt-2">
                                        <input type="text" name="columns[]" class="form-control w-auto" value="Feature" readonly>
                    
                                        <input type="text" name="columns[]" class="form-control w-auto" placeholder="DDPU">
                                        <input type="text" name="columns[]" class="form-control w-auto" placeholder="MPS">
                                        <input type="text" name="columns[]" class="form-control w-auto" placeholder="MDU">
                                        <input type="text" name="columns[]" class="form-control w-auto" placeholder="MDDUS">
                                        <input type="text" name="columns[]" class="form-control w-auto" placeholder="NHS Indemnity">
                                    </div>
                                </div>
                    
                                <!-- TABLE -->
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle text-center" id="compareTable">
                                        <thead class="table-light">
                                            <tr id="tableHeadRow">
                                                <th>Feature</th>
                                                <th>DDPU</th>
                                                <th>MPS</th>
                                                <th>MDU</th>
                                                <th>MDDUS</th>
                                                <th>NHS Indemnity</th>
                                                <th width="70">Action</th>
                                            </tr>
                                        </thead>
                    
                                        <tbody id="tableBody">
                                            <tr>
                                                <td>
                                                    <textarea name="rows[0][]" class="form-control" placeholder="Enter feature..." required></textarea>
                                                </td>
                                                <td><input type="text" name="rows[0][]" class="form-control"></td>
                                                <td><input type="text" name="rows[0][]" class="form-control"></td>
                                                <td><input type="text" name="rows[0][]" class="form-control"></td>
                                                <td><input type="text" name="rows[0][]" class="form-control"></td>
                                                <td><input type="text" name="rows[0][]" class="form-control"></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                    
                            </div>
                        </div>
                    </div>


<!-- ===== SUBMIT ===== -->
<div class="col-12 text-end">
<button class="btn btn-primary px-4">Submit</button>
</div>

</div>
</form>
</div>
</div>

</div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')

<!-- ================= JAVASCRIPT ================= -->
<script>
function previewImage(input, previewId, sizeId, removeBtnId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const sizeText = document.getElementById(sizeId);
    const removeBtn = document.getElementById(removeBtnId);

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
            removeBtn.style.display = "block";
        };

        reader.readAsDataURL(file);

        // Show File Size
        const sizeKB = (file.size / 1024).toFixed(2);
        sizeText.innerHTML = "File Size: " + sizeKB + " KB";
    }
}

function removeImage(inputName, previewId, sizeId, removeBtnId) {
    const input = document.querySelector("input[name='"+inputName+"']");
    const preview = document.getElementById(previewId);
    const sizeText = document.getElementById(sizeId);
    const removeBtn = document.getElementById(removeBtnId);

    input.value = "";
    preview.src = "";
    preview.style.display = "none";
    sizeText.innerHTML = "";
    removeBtn.style.display = "none";
}




</script>
<script>

let rowIndex = 1;

// ADD ROW
function addRow() {
    let colCount = document.querySelectorAll('#tableHeadRow th').length - 1;

    let tr = `<tr>`;

    for (let i = 0; i < colCount; i++) {
        if (i == 0) {
            tr += `<td><textarea name="rows[${rowIndex}][]" class="form-control" required></textarea></td>`;
        } else {
            tr += `<td><input type="text" name="rows[${rowIndex}][]" class="form-control"></td>`;
        }
    }

    tr += `<td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
           </td></tr>`;

    document.getElementById('tableBody').insertAdjacentHTML('beforeend', tr);

    rowIndex++;
}


// REMOVE ROW
function removeRow(btn) {
    btn.closest('tr').remove();
}


// ADD COLUMN
function addColumn() {

    let columnName = prompt("Enter Column Name");
    if (!columnName) return;

    // add heading input
    let input = `<input type="text" name="columns[]" class="form-control w-auto" value="${columnName}">`;
    document.getElementById('columnInputs').insertAdjacentHTML('beforeend', input);

    // add table header
    let th = document.createElement('th');
    th.innerText = columnName;
    document.getElementById('tableHeadRow').insertBefore(th, document.getElementById('tableHeadRow').lastElementChild);

    // add cells to each row
    let rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        let td = document.createElement('td');
        td.innerHTML = `<input type="text" name="rows[${index}][]" class="form-control">`;
        row.insertBefore(td, row.lastElementChild);
    });
}

</script>

</body>
</html>
