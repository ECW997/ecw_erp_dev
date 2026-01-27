<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
.card-header {
    background-color: white;
    border-bottom: 1px solid #6c757d;
    padding: 1rem 2rem;
}

.vehicle-status-card {
    border-left: 4px solid;
    transition: transform 0.2s;
}

.vehicle-status-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.status-in { border-left-color: #28a745; }
.status-out { border-left-color: #dc3545; }
.status-external { border-left-color: #fd7e14; }
.status-completed { border-left-color: #6c757d; }

.vehicle-info {
    font-size: 0.9rem;
}

.vehicle-info strong {
    color: #495057;
    min-width: 120px;
    display: inline-block;
}

.timeline-item {
    position: relative;
    padding-left: 30px;
    margin-bottom: 15px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: -15px;
    width: 2px;
    background: #dee2e6;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px;
}

.marker-in { background: #28a745; box-shadow: 0 0 0 2px #28a745; }
.marker-out { background: #dc3545; box-shadow: 0 0 0 2px #dc3545; }
.marker-external { background: #fd7e14; box-shadow: 0 0 0 2px #fd7e14; }

.timeline-container {
    padding: 10px 0;
}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-car"></i></div>
                            <span>Vehicle Tracking</span>
                        </h1>
                        <div>
                            <a href="<?= base_url('GatePass') ?>" class="btn btn-secondary btn-sm px-4 p-2 ml-2">
                                <i class="fas fa-list mr-2"></i>Gate Pass List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-2">
                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Vehicles IN</h6>
                                        <h3 id="countIn">0</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-arrow-circle-down fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Vehicles OUT</h6>
                                        <h3 id="countOut">0</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-arrow-circle-up fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white" style="background-color: #fd7e14;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">External Transfers</h6>
                                        <h3 id="countExternal">0</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exchange-alt fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-secondary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Total Vehicles</h6>
                                        <h3 id="countTotal">0</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-car fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label for="filterStatus">Vehicle Status</label>
                                <select id="filterStatus" class="form-control form-control-sm">
                                    <option value="">All Status</option>
                                    <option value="IN">IN</option>
                                    <option value="OUT">OUT</option>
                                    <option value="EXTERNAL">External Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterLocation">Location</label>
                                <select id="filterLocation" class="form-control form-control-sm">
                                    <option value="">All Locations</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="searchVehicle">Search Vehicle/Job Card</label>
                                <input type="text" id="searchVehicle" class="form-control form-control-sm" placeholder="Vehicle No or Job Card No" />
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary btn-sm w-100" id="filterBtn">
                                    <i class="fas fa-filter mr-2"></i>Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicle List -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Vehicle Status</h5>
                    </div>
                    <div class="card-body">
                        <div id="vehicleList" class="row">
                            <!-- Vehicles will be loaded here -->
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="text-muted mt-2">Loading vehicles...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
var base_url = '<?= base_url() ?>';

$(document).ready(function() {
    // Load locations
    loadLocations();
    
    // Load vehicles
    loadVehicles();
    
    // Filter button
    $('#filterBtn').on('click', function() {
        loadVehicles();
    });

    // Search on enter
    $('#searchVehicle').on('keypress', function(e) {
        if (e.which === 13) {
            loadVehicles();
        }
    });

    function loadLocations() {
        $.ajax({
            url: base_url + "GatePass/getLocations",
            type: "GET",
            success: function(response) {
                if (response.status && response.data) {
                    var options = '<option value="">All Locations</option>';
                    response.data.forEach(function(location) {
                        options += '<option value="' + location.id + '">' + location.location_name + '</option>';
                    });
                    $('#filterLocation').html(options);
                }
            },
            error: function() {
                console.error("Error loading locations");
            }
        });
    }

    function loadVehicles() {
        var status = $('#filterStatus').val();
        var location = $('#filterLocation').val();
        var search = $('#searchVehicle').val();

        $('#vehicleList').html('<div class="col-12 text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i><p class="text-muted mt-2">Loading vehicles...</p></div>');

        $.ajax({
            url: base_url + "GatePass/getGatePasses",
            type: "GET",
            dataType: "json",
            data: {
                status: 'ACTIVE',
                date_from: new Date(new Date().setDate(new Date().getDate() - 30)).toISOString().split('T')[0]
            },
            success: function(response) {
                // Handle string response (double-encoded JSON)
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error('Failed to parse string response:', e);
                        $('#vehicleList').html('<div class="col-12 text-center py-5"><p class="text-danger">Error: Invalid JSON response from server</p></div>');
                        return;
                    }
                }
                
                // Check if response is valid
                if (!response) {
                    console.error('Response is null or undefined');
                    $('#vehicleList').html('<div class="col-12 text-center py-5"><p class="text-danger">Error: No response from server</p></div>');
                    return;
                }
                
                if (response && (response.status === true || response.status === 'true' || response.status === 1)) {
                    // Handle both paginated and non-paginated responses
                    var gatePasses = [];
                    
                    if (response.data) {
                        // Check if it's a paginated response (Laravel paginator)
                        if (response.data.data && Array.isArray(response.data.data)) {
                            // Paginated response: { data: { data: [...], current_page: 1, ... } }
                            gatePasses = response.data.data;
                        } 
                        // Check if it's a direct array (non-paginated)
                        else if (Array.isArray(response.data)) {
                            // Direct array response (when status=ACTIVE, backend returns all records)
                            gatePasses = response.data;
                        } 
                        // Check for alternative structure
                        else if (response.data.gatePasses && Array.isArray(response.data.gatePasses)) {
                            gatePasses = response.data.gatePasses;
                        }
                        // If data is an object but not an array, try to extract items
                        else if (typeof response.data === 'object') {
                            // Try to find array in the object
                            for (var key in response.data) {
                                if (Array.isArray(response.data[key])) {
                                    gatePasses = response.data[key];
                                    break;
                                }
                            }
                        }
                    }
                    
                    if (gatePasses.length > 0) {
                        var vehicles = groupByJobCard(gatePasses);
                        
                        if (Object.keys(vehicles).length > 0) {
                            displayVehicles(vehicles, status, location, search);
                            updateSummary(vehicles);
                        } else {
                            $('#vehicleList').html('<div class="col-12 text-center py-5"><p class="text-muted">No vehicles found. Gate passes exist but job card relationships may be missing.</p></div>');
                        }
                    } else {
                        $('#vehicleList').html('<div class="col-12 text-center py-5"><p class="text-muted">No gate passes found</p></div>');
                    }
                } else {
                    var errorMsg = 'Unknown error';
                    
                    if (response.message) {
                        errorMsg = response.message;
                    } else if (response.error) {
                        errorMsg = response.error;
                    } else if (response.errors) {
                        errorMsg = JSON.stringify(response.errors);
                    } else if (typeof response === 'string') {
                        errorMsg = response;
                    } else if (response.data && response.data.message) {
                        errorMsg = response.data.message;
                    } else {
                        errorMsg = 'API returned an error. Status: ' + (response.status || 'undefined') + ', Code: ' + (response.code || 'undefined');
                    }
                    
                    console.error('Error loading gate passes:', {
                        status: response.status,
                        code: response.code,
                        message: response.message,
                        error: response.error
                    });
                    
                    $('#vehicleList').html('<div class="col-12 text-center py-5"><p class="text-danger">Error: ' + errorMsg + '</p></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('HTTP Status:', xhr.status);
                console.error('Response Text:', xhr.responseText);
                console.error('Full XHR Object:', xhr);
                
                var errorMsg = 'Failed to load vehicles';
                
                if (xhr.responseText) {
                    try {
                        var errorResponse = JSON.parse(xhr.responseText);
                        if (errorResponse.message) {
                            errorMsg = errorResponse.message;
                        } else if (errorResponse.error) {
                            errorMsg = errorResponse.error;
                        }
                    } catch (e) {
                        // If response is not JSON, use the raw text
                        if (xhr.responseText.length < 200) {
                            errorMsg = xhr.responseText;
                        }
                    }
                }
                
                if (xhr.status === 401) {
                    errorMsg = 'Authentication failed. Please login again.';
                } else if (xhr.status === 403) {
                    errorMsg = 'Access denied. You do not have permission.';
                } else if (xhr.status === 404) {
                    errorMsg = 'API endpoint not found.';
                } else if (xhr.status === 500) {
                    errorMsg = 'Server error. Please contact administrator.';
                } else if (xhr.status === 0) {
                    errorMsg = 'Network error. Please check your connection.';
                }
                
                $('#vehicleList').html('<div class="col-12 text-center py-5"><p class="text-danger">' + errorMsg + '</p><p class="text-muted small">HTTP Status: ' + xhr.status + ' | Check browser console for details</p></div>');
            }
        });
    }

    function groupByJobCard(gatePasses) {
        var vehicles = {};
        
        gatePasses.forEach(function(gatePass) {
            // Check if job_card exists
            if (!gatePass.job_card) {
                return;
            }
            
            var jobCardId = gatePass.job_card.idtbl_jobcard || gatePass.job_card.id || gatePass.job_card_id || gatePass.job_card_id;
            
            if (!jobCardId) {
                return;
            }
            
            if (!vehicles[jobCardId]) {
                vehicles[jobCardId] = {
                    jobCard: gatePass.job_card,
                    gatePasses: [],
                    currentStatus: 'UNKNOWN',
                    currentLocation: null
                };
            }
            
            vehicles[jobCardId].gatePasses.push(gatePass);
        });

        Object.keys(vehicles).forEach(function(jobCardId) {
            var vehicle = vehicles[jobCardId];
            
            // Sort by created_at (oldest first) for tracking
            vehicle.gatePasses.sort(function(a, b) {
                return new Date(a.created_at) - new Date(b.created_at);
            });

            // Track current location through gate pass sequence
            // Process ALL gate passes in chronological order to track the complete journey
            var currentLocationId = null;
            var currentStatus = 'UNKNOWN';
            
            // Process all gate passes in chronological order (oldest to newest)
            vehicle.gatePasses.forEach(function(gp) {
                if (gp.status !== 'ACTIVE') {
                    return; // Skip inactive gate passes
                }
                
                // MAIN IN - Starting point
                if (gp.pass_category === 'MAIN' && gp.gate_pass_type === 'IN') {
                    if (gp.location_id) {
                        currentLocationId = gp.location_id;
                        currentStatus = 'IN';
                    }
                }
                // MAIN OUT - Vehicle left
                else if (gp.pass_category === 'MAIN' && gp.gate_pass_type === 'OUT') {
                    currentStatus = 'OUT';
                    if (gp.location_id) {
                        currentLocationId = gp.location_id;
                    }
                }
                // INTERNAL TEMP_OUT - Vehicle leaving from_location, going to to_location
                else if (gp.pass_category === 'INTERNAL' && gp.gate_pass_type === 'TEMP_OUT') {
                    if (gp.from_location_id && gp.to_location_id) {
                        // Check if current location matches from_location
                        if (currentLocationId == gp.from_location_id) {
                            // Vehicle is leaving from_location, moving to to_location
                            currentLocationId = gp.to_location_id;
                            currentStatus = 'IN'; // Vehicle is now at to_location
                        }
                    }
                }
                // INTERNAL TEMP_IN - Vehicle entering to_location
                else if (gp.pass_category === 'INTERNAL' && gp.gate_pass_type === 'TEMP_IN') {
                    if (gp.to_location_id) {
                        // Vehicle arrives at to_location
                        currentLocationId = gp.to_location_id;
                        currentStatus = 'IN'; // Vehicle is now at to_location
                    }
                }
                // EXTERNAL TEMP_OUT - Vehicle on external transfer
                else if (gp.pass_category === 'EXTERNAL' && gp.gate_pass_type === 'TEMP_OUT' && !gp.actual_return_date) {
                    currentStatus = 'EXTERNAL';
                }
                // EXTERNAL TEMP_IN - Vehicle returned from external transfer
                else if (gp.pass_category === 'EXTERNAL' && gp.gate_pass_type === 'TEMP_IN') {
                    if (gp.to_location_id) {
                        currentLocationId = gp.to_location_id;
                        currentStatus = 'IN';
                    }
                }
            });
            
            // Find location object by ID
            if (currentLocationId) {
                // Try to find location from any gate pass
                var locationFound = false;
                
                // First, try to find from location relationship
                for (var i = 0; i < vehicle.gatePasses.length; i++) {
                    var gp = vehicle.gatePasses[i];
                    
                    // Check location
                    if (gp.location && gp.location.id == currentLocationId) {
                        vehicle.currentLocation = gp.location;
                        locationFound = true;
                        break;
                    }
                    
                    // Check from_location
                    if (gp.from_location && gp.from_location.id == currentLocationId) {
                        vehicle.currentLocation = gp.from_location;
                        locationFound = true;
                        break;
                    }
                    
                    // Check to_location
                    if (gp.to_location && gp.to_location.id == currentLocationId) {
                        vehicle.currentLocation = gp.to_location;
                        locationFound = true;
                        break;
                    }
                }
                
                // If not found, try to get from location_id match
                if (!locationFound) {
                    var locationGatePass = vehicle.gatePasses.find(function(gp) {
                        return gp.location_id == currentLocationId || 
                               gp.from_location_id == currentLocationId || 
                               gp.to_location_id == currentLocationId;
                    });
                    
                    if (locationGatePass) {
                        // Try to get location from location object
                        if (locationGatePass.location && locationGatePass.location.id == currentLocationId) {
                            vehicle.currentLocation = locationGatePass.location;
                        } else if (locationGatePass.from_location && locationGatePass.from_location.id == currentLocationId) {
                            vehicle.currentLocation = locationGatePass.from_location;
                        } else if (locationGatePass.to_location && locationGatePass.to_location.id == currentLocationId) {
                            vehicle.currentLocation = locationGatePass.to_location;
                        } else {
                            // Fallback: create location object from ID
                            vehicle.currentLocation = { id: currentLocationId, location_name: 'Location ' + currentLocationId };
                        }
                    } else {
                        // Last resort: create minimal location object
                        vehicle.currentLocation = { id: currentLocationId, location_name: 'Location ' + currentLocationId };
                    }
                }
            }
            
            vehicle.currentStatus = currentStatus;
        });

        return vehicles;
    }

    function displayVehicles(vehicles, statusFilter, locationFilter, searchFilter) {
        var html = '';
        var modalsHtml = '';
        var count = 0;

        Object.keys(vehicles).forEach(function(jobCardId) {
            var vehicle = vehicles[jobCardId];
            var jobCard = vehicle.jobCard;

            if (statusFilter && vehicle.currentStatus !== statusFilter) return;
            if (locationFilter && (!vehicle.currentLocation || vehicle.currentLocation.id != locationFilter)) return;
            if (searchFilter) {
                var searchLower = searchFilter.toLowerCase();
                var vehicleNo = (jobCard.vehicle_number || '').toLowerCase();
                var jobCardNo = ((jobCard.job_card_number || '') + (jobCard.job_card_number2 || '')).toLowerCase();
                if (vehicleNo.indexOf(searchLower) === -1 && jobCardNo.indexOf(searchLower) === -1) return;
            }

            count++;

            var statusClass = 'status-in';
            var statusIcon = 'fa-arrow-circle-down';
            var statusText = 'IN';
            
            if (vehicle.currentStatus === 'OUT') {
                statusClass = 'status-out';
                statusIcon = 'fa-arrow-circle-up';
                statusText = 'OUT';
            } else if (vehicle.currentStatus === 'EXTERNAL') {
                statusClass = 'status-external';
                statusIcon = 'fa-exchange-alt';
                statusText = 'External Transfer';
            }

            html += '<div class="col-md-6 col-lg-4 mb-3">';
            html += '<div class="card vehicle-status-card ' + statusClass + '">';
            html += '<div class="card-body">';
            html += '<div class="d-flex justify-content-between align-items-start mb-2">';
            html += '<h6 class="card-title mb-0"><i class="fas ' + statusIcon + ' mr-2"></i>' + statusText + '</h6>';
            html += '<span class="badge badge-' + (vehicle.currentStatus === 'IN' ? 'success' : vehicle.currentStatus === 'EXTERNAL' ? 'warning' : 'danger') + '">' + vehicle.currentStatus + '</span>';
            html += '</div>';
            
            html += '<div class="vehicle-info mb-2">';
            html += '<div><strong>Vehicle:</strong> ' + (jobCard.vehicle_number || '-') + '</div>';
            html += '<div><strong>Job Card:</strong> ' + (jobCard.job_card_number2 || jobCard.job_card_number || '-') + '</div>';
            if (jobCard.customer && jobCard.customer.customer_name) {
                html += '<div><strong>Customer:</strong> ' + jobCard.customer.customer_name + '</div>';
            }
            if (vehicle.currentLocation) {
                html += '<div><strong>Current Location:</strong> ' + vehicle.currentLocation.location_name + '</div>';
            }
            html += '</div>';

            html += '<div class="mt-3">';
            html += '<div class="d-flex justify-content-between align-items-center mb-2">';
            html += '<small class="text-muted"><strong>Gate Pass History:</strong></small>';
            html += '<button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#gatePassHistoryModal' + jobCardId + '">';
            html += '<i class="fas fa-list mr-1"></i>View All (' + vehicle.gatePasses.length + ')';
            html += '</button>';
            html += '</div>';
            html += '<div class="mt-2">';
            
            // Show first 3 gate passes in card preview
            var recentPasses = vehicle.gatePasses.slice().sort(function(a, b) {
                return new Date(b.created_at) - new Date(a.created_at);
            }).slice(0, 3);
            
            if (recentPasses.length === 0) {
                html += '<p class="text-muted small mb-0">No gate passes found</p>';
            } else {
                recentPasses.forEach(function(gp) {
                var markerClass = 'marker-in';
                if (gp.gate_pass_type === 'OUT' || gp.gate_pass_type === 'TEMP_OUT') {
                    markerClass = gp.pass_category === 'EXTERNAL' ? 'marker-external' : 'marker-out';
                }
                
                // Get location name
                var locationName = '';
                
                // For temporary IN/OUT, show to_location name
                if (gp.pass_category === 'INTERNAL' || gp.pass_category === 'EXTERNAL') {
                    if (gp.to_location && gp.to_location.location_name) {
                        locationName = gp.to_location.location_name;
                    } else if (gp.from_location && gp.from_location.location_name) {
                        locationName = gp.from_location.location_name;
                    } else if (gp.location && gp.location.location_name) {
                        locationName = gp.location.location_name;
                    }
                } else {
                    // For MAIN gate passes, show location
                    if (gp.location && gp.location.location_name) {
                        locationName = gp.location.location_name;
                    } else if (gp.to_location && gp.to_location.location_name) {
                        locationName = gp.to_location.location_name;
                    } else if (gp.from_location && gp.from_location.location_name) {
                        locationName = gp.from_location.location_name;
                    }
                }
                
                html += '<div class="timeline-item">';
                html += '<div class="timeline-marker ' + markerClass + '"></div>';
                html += '<div>';
                html += '<strong>' + gp.gate_pass_number + '</strong> ';
                html += '<span class="badge badge-sm badge-secondary">' + gp.gate_pass_type + '</span> ';
                html += '<span class="badge badge-sm badge-info">' + gp.pass_category + '</span>';
                if (locationName) {
                    html += '<div class="text-muted small mt-1"><i class="fas fa-map-marker-alt mr-1"></i>' + locationName + '</div>';
                }
                html += '<div class="text-muted small">' + new Date(gp.created_at).toLocaleString() + '</div>';
                html += '</div>';
                html += '</div>';
                });
            }
            
            html += '</div>';
            html += '</div>';
            
            // Create modal HTML separately (outside card structure) - use modalsHtml variable
            modalsHtml += '<div class="modal fade" id="gatePassHistoryModal' + jobCardId + '" tabindex="-1" role="dialog" aria-labelledby="gatePassHistoryModalLabel' + jobCardId + '">';
            modalsHtml += '<div class="modal-dialog modal-lg" role="document" style="max-width: 800px;">';
            modalsHtml += '<div class="modal-content">';
            modalsHtml += '<div class="modal-header bg-primary text-white">';
            modalsHtml += '<h5 class="modal-title" id="gatePassHistoryModalLabel' + jobCardId + '">';
            modalsHtml += '<i class="fas fa-history mr-2"></i>Complete Gate Pass History - ' + (jobCard.vehicle_number || 'N/A');
            modalsHtml += '</h5>';
            modalsHtml += '<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">';
            modalsHtml += '<span aria-hidden="true">&times;</span>';
            modalsHtml += '</button>';
            modalsHtml += '</div>';
            modalsHtml += '<div class="modal-body p-4" style="max-height: 80vh; overflow-y: auto;">';
            modalsHtml += '<div class="timeline-container">';
            
            // Show all gate passes in modal, sorted by date (oldest first for chronological view)
            var allPasses = vehicle.gatePasses.slice().sort(function(a, b) {
                return new Date(a.created_at) - new Date(b.created_at);
            });
            
            allPasses.forEach(function(gp, index) {
                var markerClass = 'marker-in';
                if (gp.gate_pass_type === 'OUT' || gp.gate_pass_type === 'TEMP_OUT') {
                    markerClass = gp.pass_category === 'EXTERNAL' ? 'marker-external' : 'marker-out';
                }
                
                // Get location name
                var locationName = '';
                
                // For temporary IN/OUT, show to_location name
                if (gp.pass_category === 'INTERNAL' || gp.pass_category === 'EXTERNAL') {
                    if (gp.to_location && gp.to_location.location_name) {
                        locationName = gp.to_location.location_name;
                    } else if (gp.from_location && gp.from_location.location_name) {
                        locationName = gp.from_location.location_name;
                    } else if (gp.location && gp.location.location_name) {
                        locationName = gp.location.location_name;
                    }
                } else {
                    // For MAIN gate passes, show location
                    if (gp.location && gp.location.location_name) {
                        locationName = gp.location.location_name;
                    } else if (gp.to_location && gp.to_location.location_name) {
                        locationName = gp.to_location.location_name;
                    } else if (gp.from_location && gp.from_location.location_name) {
                        locationName = gp.from_location.location_name;
                    }
                }
                
                modalsHtml += '<div class="timeline-item">';
                modalsHtml += '<div class="timeline-marker ' + markerClass + '"></div>';
                modalsHtml += '<div class="p-3 border rounded bg-light mb-2">';
                modalsHtml += '<div class="d-flex justify-content-between align-items-start mb-2">';
                modalsHtml += '<div>';
                modalsHtml += '<strong class="text-primary" style="font-size: 14px;">Step ' + (index + 1) + ': ' + gp.gate_pass_number + '</strong> ';
                modalsHtml += '<span class="badge badge-sm badge-secondary ml-2">' + gp.gate_pass_type + '</span> ';
                modalsHtml += '<span class="badge badge-sm badge-info">' + gp.pass_category + '</span>';
                modalsHtml += '</div>';
                modalsHtml += '<small class="text-muted"><i class="fas fa-clock mr-1"></i>' + new Date(gp.created_at).toLocaleString() + '</small>';
                modalsHtml += '</div>';
                if (locationName) {
                    modalsHtml += '<div class="text-muted small"><i class="fas fa-map-marker-alt mr-1 text-danger"></i><strong>Location:</strong> ' + locationName + '</div>';
                }
                modalsHtml += '</div>';
                modalsHtml += '</div>';
            });
            
            modalsHtml += '</div>';
            modalsHtml += '</div>';
            modalsHtml += '<div class="modal-footer">';
            modalsHtml += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
            modalsHtml += '<a href="' + base_url + 'GatePass?job_card_id=' + jobCardId + '" class="btn btn-primary">View Full Details</a>';
            modalsHtml += '</div>';
            modalsHtml += '</div>';
            modalsHtml += '</div>';
            modalsHtml += '</div>';

            html += '<div class="mt-3">';
            html += '<a href="' + base_url + 'GatePass?job_card_id=' + jobCardId + '" class="btn btn-sm btn-outline-primary">View Details</a>';
            html += '</div>';

            html += '</div>';
            html += '</div>';
            html += '</div>';
        });

        if (count === 0) {
            html = '<div class="col-12 text-center py-5"><p class="text-muted">No vehicles found matching the filters</p></div>';
        }

        // Set cards HTML
        $('#vehicleList').html(html);
        
        // Append modals outside the card structure (at the end of body or in a dedicated container)
        if (modalsHtml) {
            // Remove existing modals first to avoid duplicates
            $('.modal[id^="gatePassHistoryModal"]').remove();
            // Append modals to body
            $('body').append(modalsHtml);
        }
    }

    function updateSummary(vehicles) {
        var countIn = 0;
        var countOut = 0;
        var countExternal = 0;

        Object.keys(vehicles).forEach(function(jobCardId) {
            var vehicle = vehicles[jobCardId];
            if (vehicle.currentStatus === 'IN') countIn++;
            else if (vehicle.currentStatus === 'OUT') countOut++;
            else if (vehicle.currentStatus === 'EXTERNAL') countExternal++;
        });

        $('#countIn').text(countIn);
        $('#countOut').text(countOut);
        $('#countExternal').text(countExternal);
        $('#countTotal').text(countIn + countOut + countExternal);
    }
});
</script>

