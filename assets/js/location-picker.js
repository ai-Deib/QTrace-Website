let locationPickerMap;
let locationMarkers = [];
let selectedLocationMarker = null;
let selectedLocationId = null;
let allLocations = [];
let customMarker = null;
let isCustomLocation = false;

/* Quezon City center */
const QC_CENTER = [14.6760, 121.0437];

/* Approximate Quezon City bounds */
const QC_BOUNDS = [
  [14.620, 120.980], // Southwest
  [14.760, 121.120]  // Northeast
];

/* Initialize location picker map */
window.initLocationPickerMap = function () {
  // Create map centered on Quezon City
  locationPickerMap = L.map('locationPickerMap', {
    center: QC_CENTER,
    zoom: 13,
    minZoom: 12,
    maxZoom: 18,
    maxBounds: QC_BOUNDS,
    maxBoundsViscosity: 1.0
  });

  // Add OpenStreetMap tile layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 18
  }).addTo(locationPickerMap);

  // Add click event to drop custom marker
  locationPickerMap.on('click', function(e) {
    dropCustomMarker(e.latlng);
  });

  // Load locations from API
  loadLocationsFromAPI();
};

// Auto-initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  if (document.getElementById('locationPickerMap')) {
    initLocationPickerMap();
  }
});

/* Load locations from PHP API */
function loadLocationsFromAPI() {
  const apiUrl = '../../database/controllers/get_locations.php';
  
  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        allLocations = data.data;
        renderLocationMarkers(allLocations);
      } else {
        console.error('Error loading locations:', data.error);
        showLocationError('Failed to load locations');
      }
    })
    .catch(error => {
      console.error('API Error:', error);
      showLocationError('Error connecting to server');
    });
}

/* Show error message */
function showLocationError(message) {
  console.error(message);
}

/* Render location markers on map */
function renderLocationMarkers(data) {
  locationMarkers.forEach(m => locationPickerMap.removeLayer(m));
  locationMarkers = [];

  data.forEach(location => {
    const blueIcon = L.divIcon({
      className: 'custom-marker',
      html: `<div style="background-color: #3b82f6; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
      iconSize: [20, 20],
      iconAnchor: [10, 10]
    });

    const marker = L.marker(
      [location.position.lat, location.position.lng],
      { icon: blueIcon }
    ).addTo(locationPickerMap);

    marker.on('click', () => {
      selectLocation(location, marker);
    });

    locationMarkers.push(marker);
  });
}

/* Select a location */
function selectLocation(location, marker) {
  // Clear previous selection
  if (selectedLocationMarker) {
    const blueIcon = L.divIcon({
      className: 'custom-marker',
      html: `<div style="background-color: #3b82f6; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
      iconSize: [20, 20],
      iconAnchor: [10, 10]
    });
    selectedLocationMarker.setIcon(blueIcon);
  }

  // Set new selection
  selectedLocationId = location.id;
  selectedLocationMarker = marker;
  
  const redIcon = L.divIcon({
    className: 'custom-marker',
    html: `<div style="background-color: #ef4444; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
    iconSize: [20, 20],
    iconAnchor: [10, 10]
  });
  marker.setIcon(redIcon);

  // Update form fields
  const locationIdField = document.getElementById('location_id_value');
  if (locationIdField) {
    locationIdField.value = location.id;
  }

  // Update display
  const locationDisplay = document.getElementById('selectedLocationDisplay');
  if (locationDisplay) {
    locationDisplay.innerHTML = `
      <div class="alert alert-info mb-0">
        <strong>Selected Location:</strong><br>
        ${location.address}<br>
        <small>${location.barangay}, District ${location.district_number}</small>
      </div>
    `;
  }

  // Pan map to location
  locationPickerMap.setView([location.position.lat, location.position.lng], 15);
}

/* Clear location selection */
function clearLocationSelection() {
  if (selectedLocationMarker) {
    const blueIcon = L.divIcon({
      className: 'custom-marker',
      html: `<div style="background-color: #3b82f6; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
      iconSize: [20, 20],
      iconAnchor: [10, 10]
    });
    selectedLocationMarker.setIcon(blueIcon);
  }
  
  // Remove custom marker if exists
  if (customMarker) {
    locationPickerMap.removeLayer(customMarker);
    customMarker = null;
  }
  
  selectedLocationId = null;
  selectedLocationMarker = null;
  isCustomLocation = false;

  const locationIdField = document.getElementById('location_id_value');
  if (locationIdField) {
    locationIdField.value = '';
  }
  
  // Clear custom location fields
  const latField = document.getElementById('custom_latitude');
  const lngField = document.getElementById('custom_longitude');
  const addressField = document.getElementById('custom_address');
  const barangayField = document.getElementById('custom_barangay');
  const districtField = document.getElementById('custom_district');
  
  if (latField) latField.value = '';
  if (lngField) lngField.value = '';
  if (addressField) addressField.value = '';
  if (barangayField) barangayField.value = '';
  if (districtField) districtField.value = '';

  const locationDisplay = document.getElementById('selectedLocationDisplay');
  if (locationDisplay) {
    locationDisplay.innerHTML = '';
  }
}

/* Drop custom marker at clicked location */
function dropCustomMarker(latlng) {
  // Clear previous selection
  clearLocationSelection();
  
  // Create custom pin marker (orange/purple for custom locations)
  const customIcon = L.divIcon({
    className: 'custom-marker',
    html: `<div style="background-color: #f59e0b; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 3px 6px rgba(0,0,0,0.4);"></div>`,
    iconSize: [24, 24],
    iconAnchor: [12, 12]
  });
  
  customMarker = L.marker(latlng, { icon: customIcon }).addTo(locationPickerMap);
  customMarker.bindPopup('Custom Location - Click to edit details').openPopup();
  
  isCustomLocation = true;
  
  // Store coordinates in hidden fields
  const latField = document.getElementById('custom_latitude');
  const lngField = document.getElementById('custom_longitude');
  
  if (latField) latField.value = latlng.lat.toFixed(6);
  if (lngField) lngField.value = latlng.lng.toFixed(6);
  
  // Update display
  const locationDisplay = document.getElementById('selectedLocationDisplay');
  if (locationDisplay) {
    locationDisplay.innerHTML = `
      <div class="alert alert-warning mb-0">
        <strong>Custom Location Dropped!</strong><br>
        <small>Latitude: ${latlng.lat.toFixed(6)}, Longitude: ${latlng.lng.toFixed(6)}</small><br>
        <small class="text-muted">Please fill in the location details below</small>
      </div>
    `;
  }
  
  // Show custom location form
  const customLocationForm = document.getElementById('customLocationForm');
  if (customLocationForm) {
    customLocationForm.style.display = 'block';
  }
  
  // Pan to location
  locationPickerMap.setView(latlng, 15);
}

/* Save custom location to database */
function saveCustomLocation() {
  const latitude = document.getElementById('custom_latitude')?.value;
  const longitude = document.getElementById('custom_longitude')?.value;
  const address = document.getElementById('custom_address')?.value;
  const barangay = document.getElementById('custom_barangay')?.value;
  const district = document.getElementById('custom_district')?.value;
  
  if (!latitude || !longitude || !address || !barangay || !district) {
    alert('Please fill in all location details');
    return;
  }
  
  // Send to backend to save location
  const formData = new FormData();
  formData.append('latitude', latitude);
  formData.append('longitude', longitude);
  formData.append('address', address);
  formData.append('barangay', barangay);
  formData.append('district_number', district);
  
  fetch('../../database/controllers/save_location.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Set the newly created location ID
      const locationIdField = document.getElementById('location_id_value');
      if (locationIdField) {
        locationIdField.value = data.location_id;
      }
      
      // Update display
      const locationDisplay = document.getElementById('selectedLocationDisplay');
      if (locationDisplay) {
        locationDisplay.innerHTML = `
          <div class="alert alert-success mb-0">
            <strong>Location Saved!</strong><br>
            ${address}, ${barangay}, District ${district}<br>
            <small>Ready to create project</small>
          </div>
        `;
      }
      
      // Hide form
      const customLocationForm = document.getElementById('customLocationForm');
      if (customLocationForm) {
        customLocationForm.style.display = 'none';
      }
      
      // Reload locations to show the new one
      loadLocationsFromAPI();
    } else {
      alert('Error saving location: ' + (data.error || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Failed to save location');
  });
}
