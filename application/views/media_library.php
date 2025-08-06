<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <style>
        .custom-file-input~.custom-file-label::after {
            content: "Browse";
        }

        #imagePreview {
            display: block;
            max-width: 100%;
            height: auto;
            border: 3px solid #007bff;
            border-radius: 8px;
            padding: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #addPriceModalCenter .modal-content {
            border: 4px solid #0982e6;
            border-radius: 25px;
        }
        </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa fa-image"></i></div>
                            <span>Media Library</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Media_library/media_libraryInsert" method="post"
                                    autocomplete="off" enctype="multipart/form-data">
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold">Upload File (Max 50MB)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="design_image[]"
                                                id="design_image" multiple required onchange="validateFileSize(this)">
                                            <label class="custom-file-label" for="design_image">Choose image...</label>
                                        </div>
                                        <div class="mt-3">
                                            <div id="imagePreview" style="display: none;"></div>
                                        </div>
                                        <small class="text-muted">Maximum file size: 50MB</small>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Media Type*</label>
                                        <input type="text" class="form-control form-control-sm" name="media_type"
                                            id="media_type" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Description</label>
                                        <textarea class="form-control form-control-sm" name="description"
                                            id="description" rows="2"></textarea>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Category*</label>
                                        <select class="form-control form-control-sm selecter2 px-0" name="category"
                                            id="category" required>
                                            <option value="">Select</option>
                                            <option value="1">Stitching Design</option>
                                            <option value="2">Marketing</option>
                                            <option value="3">Production</option>
                                            <option value="4">DOT Design</option>

                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                    	<label class="small font-weight-bold">Is Active*</label>
                                    	<select class="form-control form-control-sm selecter2 px-0" name="is_active"
                                    		id="is_active" required>
                                    		<option value="1">Yes</option>
                                    		<option value="2">No</option>
                                    	</select>
                                    </div>
                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Media Type</th>
                                                <th>File</th>
                                                <th>Description</th>
                                                <th>Category</th>
                                                <th>Upload At</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<!-- Modal for Image Preview -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Preview">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
function validateFileSize(input) {
    const maxSize = 50 * 1024 * 1024; 
    let valid = true;

    if (input.files) {
        for (let i = 0; i < input.files.length; i++) {
            if (input.files[i].size > maxSize) {
                valid = false;
                alert('File "' + input.files[i].name + '" exceeds the 50MB limit.');
                input.value = ''; 
                break;
            }
        }
    }

    if (valid) {
        previewImage(event); 
    }
}
</script>

<script>
function previewImage(event) {
    const input = event.target;
    const file = input.files[0];
    const preview = document.getElementById('imagePreview');
    const label = input.nextElementSibling;
    const mediaTypeInput = document.getElementById('media_type');

    const fileName = file.name;
    const fileType = file.type;

    label.innerText = fileName;

    // Detect media type
    let mediaType = 'other';
    if (fileType.startsWith('image/')) {
        mediaType = 'image';
    } else if (fileType.startsWith('video/')) {
        mediaType = 'video';
    } else if (fileType === 'application/pdf') {
        mediaType = 'pdf';
    }

    mediaTypeInput.value = mediaType;

    const reader = new FileReader();
    reader.onload = function(e) {
        let result = '';

        if (fileType.startsWith('image/')) {
            result =
                `<img src="${e.target.result}" class="w-100" style="max-height: 300px; border-radius: 8px;" alt="Image preview">`;
        } else if (fileType.startsWith('video/')) {
            result = `<video controls style="width: 100%; max-height: 300px; border-radius: 8px;">
                        <source src="${e.target.result}" type="${fileType}">
                        Your browser does not support the video tag.
                      </video>`;
        } else if (fileType === 'application/pdf') {
            result =
                `<embed src="${e.target.result}" type="application/pdf" width="100%" height="300px" style="border-radius: 8px;" />`;
        } else {
            result = `<p class="text-muted">Preview not available for this file type.</p>`;
        }

        preview.innerHTML = result;
        preview.style.display = 'block';
    };

    reader.readAsDataURL(file);
}
</script>

<script>
function viewLargeImage(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    $('#imageModal').modal('show');
}
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        buttons: [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Media Library',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Media Library',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Media Library',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            }
        ],
        ajax: {
            url: apiBaseUrl + '/v1/media_library',
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            dataSrc: function(json) {
                if (json.success === false && json.code === 401) {
                    falseResponse(errorObj);
                    return [];
                }

                return json.data;
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    falseResponse(errorObj);
                }
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "media_id",
                "className": "text-center"
            },
            {
                "data": "media_type",
                "className": "text-center"
            },
            {
                "data": "public_url",
                "className": "text-center",
                "render": function(data, type, row) {
                    if (row.media_type == 'Image') {
                        return `<img src="${data}" 
                     class="img-thumbnail" 
                     style="max-height: 100px; cursor: pointer;" 
                     onclick="viewLargeImage('${data}')" 
                     alt="${row.file_name}">`;
                    } else if (row.media_type == 'Pdf') {
                        return `<a href="${data}" 
                     target="_blank" 
                     class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf"></i> View PDF
                    </a>`;
                    } else {
                        return `<a href="${data}" 
                     target="_blank" 
                     class="btn btn-sm btn-primary">
                        <i class="fas fa-download"></i> Download
                    </a>`;
                    }
                }
            },
            {
                "data": "description",
                "className": "text-center"
            },
            {
                "data": "category",
                "className": "text-center"
            },
            {
                "data": "uploaded_at",
                "className": "text-center",
                "render": function(data) {
                    return new Date(data).toLocaleString();
                }
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button='';
                    button+='<button title="Edit" onclick="edit('+full['media_id']+');" class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['media_id']+'"><i class="fas fa-pen"></i></button>';
                    if(full['is_active']==1){
                        button+='<button title="Deactive" onclick="statusUpdate('+full['media_id']+',2);" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></button>';
                    }else{
                        button+='<button title="Active" onclick="statusUpdate('+full['media_id']+',1);" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></button>';
                    }
                    button+='<button title="Delete" onclick="statusUpdate('+full['media_id']+',3);" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></button>';
                    
                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
});


function edit(id){
    if(edit_confirm() == true){
        $.ajax({
                type: "GET",
                dataType: 'json',
                url: '<?php echo base_url() ?>Media_library/Media_libraryEdit/' + id,
                success: function(result) {
                    if (result.status) {
                        $('#media_type').val(result.data.media_type);
                        $('#description').val(result.data.description);
                        $('#category').val(result.data.category);
                        $('#is_active').val(result.data.is_active);
                        $('#recordID').val(result.data.id);

                        $('#design_image').prop('required', false);
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    } else {
                        falseResponse(result);
                    }
                }
        });
    }
}    

function statusUpdate(id,status){
    var r = '';
    if(status == '1'){
        r = active_confirm();
    }else if(status == '2'){
        r = deactive_confirm();
    }else{
        r = delete_confirm();
    }

    if (r == true) {
        $.ajax({
                type: "PUT",
                dataType: 'json',
                url: '<?php echo base_url() ?>Media_library/Media_librarystatus/' + id + '/' + status,
                success: function(result) {
                    if (result.status) {
                        success_toastify(result.message);
                          setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        falseResponse(result);
                    }
                }
        });
    }   

}

function edit_confirm() {
    return confirm("Are you sure, You want to Edit this ?");
}

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}

</script>
<?php include "include/footer.php"; ?>