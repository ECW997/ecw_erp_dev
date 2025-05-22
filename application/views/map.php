<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<style>
#treeContainer ul {
  padding-left: 20px;
  position: relative;
  list-style: none; /* Remove bullets */
}

#treeContainer ul ul {
  margin-left: 20px;
}

#treeContainer ul::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0x;
  width: 0;
  height: 100%;
  border-left: 1px solid #ccc;
}

#treeContainer li {
  position: relative;
  padding: 10px 0 0 20px;
}

#treeContainer li::before {
  content: '';
  position: absolute;
  top: 22px;
  left: 0;
  width: 20px;
  height: 1px;
  border-top: 1px solid #ccc;
}

#treeContainer li:last-child::before {
  background: white;
}
</style>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="map"></i></div>
                            <span>Map</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                        	<div class="col-3">
                        		<label class="small font-weight-bold">Main Job Category*</label>
                        		<select class="form-control form-control-sm " name="main_job_category"
                        			id="main_job_category" required>
                        			<option value="">Select</option>
                        		</select>
                        	</div>
                        	<div class="col-3">
                        		<label class="small font-weight-bold">Sub Job Category*</label>
                        		<select class="form-control form-control-sm " name="sub_job_category"
                        			id="sub_job_category" onchange="getMapDetails(this.value);" required>
                        			<option value="">Select</option>
                        		</select>
                        	</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-danger btn-sm px-4 mt-auto p-2" onclick="exportPDF();"><i class="fas fa-file-pdf mr-2"></i>Export</button>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div id="treeContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>

<script>
$(document).ready(function() {
    let main_job_category = $('#main_job_category');
    let sub_job_category = $('#sub_job_category');

    main_job_category.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>SubJobCategory/getMainJob',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                }
            },
            cache: true,
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.item.length > 0
                        }
                    }
                } else {
                    falseResponse(data);
                }
            }
        }
    });

    sub_job_category.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>SubJobCategory/getSubJob',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    mainJob: main_job_category.val()
                }
            },
            cache: true,
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.item.length > 0
                        }
                    }
                } else {
                    falseResponse(data);
                }
            }
        }
    });

    getMapDetails(sub_job_category.val());
});

function getMapDetails(sub_job_category){
    $.ajax({
        url: apiBaseUrl+'/v1/map', 
        type: "GET",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + api_token 
        }, 
        data: {sub_job_category: sub_job_category},
        success: function(result) {
            if (result.status) {
                renderTree(result.data); 
               
            } else {
                falseResponse(result);
            }
        }
    });
}

function renderTree(data) {
    let html = '<ul>';

    data.subjob_categories.forEach(subCategory => {
        html += `<li><strong>${subCategory.sub_job_category}</strong><ul>`;
        if (data.optionGroups[subCategory.idtbl_sub_job_category]) {
            data.optionGroups[subCategory.idtbl_sub_job_category].forEach(group => {
                if (group.JobSubcategoryID == subCategory.idtbl_sub_job_category) {
                    html += `<li><strong>${group.GroupName}</strong><ul>`;
                    Object.keys(data.jobOptions).forEach(key => {
                        const options = data.jobOptions[key];

                        options.forEach(option => {
                            if (option.JobSubcategoryID == subCategory.idtbl_sub_job_category && option.OptionGroupID == group.id && option.OptionType != 'Conditional') {
                                html += `<li><strong>${option.OptionName}</strong> - ${option.OptionType}`;
                                if (option.OptionType != 'Conditional' && data.OptionValues[option.JobOptionID]) {
                                    html += '<ul>';
                                    data.OptionValues[option.JobOptionID].forEach(primaryValue => {
                                        html += `<li><strong>${primaryValue.ValueName} (${primaryValue.price_category_type})</strong> - ${primaryValue.Price}`;
                                        Object.keys(data.jobOptions).forEach(childKey => {
                                            const childOptions = data.jobOptions[childKey];
                                            childOptions.forEach(childOption => { 
                                                if (childOption.OptionType == 'Conditional' && childOption.OptionGroupID == group.id) {
                                                    html += `<ul><li><strong>${childOption.OptionName}</strong> - ${childOption.OptionType}`;
                                                    if (data.OptionValues[childOption.JobOptionID]) {
                                                        html += '<ul>';
                                                        data.OptionValues[childOption.JobOptionID].forEach(childValue => {
                                                            if(childValue.ParentOptionValueID == option.JobOptionID){
                                                                html += `<li>${childValue.ValueName}</li>`;
                                                            }
                                                        });
                                                        html += '</ul>';
                                                    }
                                                    html += `</li></ul>`;
                                                }
                                            });
                                        });
                                        html += `</li>`; 
                                    });
                                    html += '</ul>';
                                }
                                html += '</li>';
                            }
                        });

                    });
                    
                    html += `</ul></li>`;
                }
            });
        }

        html += '<br><hr>';
        html += '</ul></li>';
    });

    html += '</ul>';

    document.getElementById('treeContainer').innerHTML = html;

}

function exportPDF() {

    var content = $('#treeContainer').html();

    $.ajax({
        url: '<?= base_url("Map/generate_pdf") ?>',
        method: 'POST',
        data: { html_content: content },
        xhrFields: {
            responseType: 'blob' // important for binary PDF response
        },
        success: function (response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "Map.pdf";
            link.click();
        },
        error: function () {
            alert("Error generating PDF");
        }
    });

    // let sub_job_category = $('#sub_job_category').val();

    // const baseUrl = "<?php echo base_url(); ?>Map/getMapPdf";
    // const url = `${baseUrl}?sub_job_category=${encodeURIComponent(sub_job_category)}`;

    // window.location.href = url;
}


</script>
<?php include "include/footer.php"; ?>