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
    getMapDetails();
});

function getMapDetails(){
    $.ajax({
        url: apiBaseUrl+'/v1/map', 
        type: "GET",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + api_token 
        }, 
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
                if (group.JobSubcategoryID === subCategory.idtbl_sub_job_category) {
                    html += `<li><strong>${group.GroupName}</strong><ul>`;

                    Object.keys(data.jobOptions).forEach(key => {
                        const options = data.jobOptions[key];

                        options.forEach(option => {
                            if (option.JobSubcategoryID === subCategory.idtbl_sub_job_category && option.OptionGroupID === group.id && option.OptionType !== 'Conditional') {
                                html += `<li><strong>${option.OptionName}</strong> - ${option.OptionType}`;
                                if (option.OptionType !== 'Conditional' && data.OptionValues[option.JobOptionID]) {
                                    html += '<ul>';
                                    data.OptionValues[option.JobOptionID].forEach(primaryValue => {
                                        html += `<li><strong>${primaryValue.ValueName}</strong>`;

                                        Object.keys(data.jobOptions).forEach(childKey => {
                                            const childOptions = data.jobOptions[childKey];
                                            childOptions.forEach(childOption => { 
                                                if (childOption.OptionType === 'Conditional' && childOption.OptionGroupID === group.id) {
                                                    html += `<ul><li><strong>${childOption.OptionName}</strong> - ${childOption.OptionType}`;
                                                    if (data.OptionValues[childOption.JobOptionID]) {
                                                        html += '<ul>';
                                                        data.OptionValues[childOption.JobOptionID].forEach(childValue => {
                                                            if(childValue.ParentOptionValueID === option.JobOptionID){
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

        html += '</ul></li>';
    });

    html += '</ul>';

    document.getElementById('treeContainer').innerHTML = html;

}


</script>
<?php include "include/footer.php"; ?>