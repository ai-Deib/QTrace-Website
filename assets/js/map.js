let map;
let markers = [];
let allProjects = [];

/* Quezon City center */
const QC_CENTER = [14.6760, 121.0437];

/* Approximate Quezon City bounds */
const QC_BOUNDS = [
  [14.620, 120.980], // Southwest
  [14.760, 121.120]  // Northeast
];

/* Initialize OpenStreetMap with Leaflet */
window.initMap = function () {
  // Create map centered on Quezon City
  map = L.map('map', {
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
  }).addTo(map);

  // Load projects from API
  loadProjectsFromAPI();
  bindFilters();
};

// Auto-initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  initMap();
});

/* Load projects from PHP API */
function loadProjectsFromAPI() {
  const apiUrl = '../../database/controllers/get_map_data.php';
  
  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        allProjects = data.data;
        applyFilters();
      } else {
        console.error('Error loading map data:', data.error);
        showError('Failed to load project data');
      }
    })
    .catch(error => {
      console.error('API Error:', error);
      showError('Error connecting to server');
    });
}

/* Show error message */
function showError(message) {
  const projectList = document.getElementById('projects');
  if (projectList) {
    projectList.innerHTML = `<div style="color: red; padding: 10px;">${message}</div>`;
  }
}

/* Marker color by status */
function markerColor(status) {
  const colors = {
    'Planned': '#3b82f6',
    'Ongoing': '#10b981',
    'Delayed': '#ef4444',
    'Completed': '#9ca3af'
  };
  return colors[status] || '#9ca3af';
}

/* Create custom marker icon */
function createMarkerIcon(color) {
  return L.divIcon({
    className: 'custom-marker',
    html: `<div style="background-color: ${color}; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>`,
    iconSize: [24, 24],
    iconAnchor: [12, 12],
    popupAnchor: [0, -12]
  });
}

/* Apply filters */
function applyFilters() {
  const status = document.getElementById('statusFilter').value;
  const category = document.getElementById('categoryFilter').value;

  const filtered = allProjects.filter(p => {
    const statusMatch = status === 'all' || p.status === status;
    const categoryMatch = category === 'all' || p.category === category;
    return statusMatch && categoryMatch;
  });

  renderMarkers(filtered);
  renderList(filtered);
}

/* Render markers + Popups */
function renderMarkers(data) {
  markers.forEach(m => map.removeLayer(m));
  markers = [];

  data.forEach(project => {
    const marker = L.marker(
      [project.position.lat, project.position.lng],
      { icon: createMarkerIcon(markerColor(project.status)) }
    ).addTo(map);

    // Create popup content
    const popupContent = `
      <div style="max-width:220px">
        <strong>${project.name}</strong><br>
        <small><b>Category:</b> ${project.category}</small><br>
        <small><b>Status:</b> ${project.status}</small><br>
        <small><b>Area:</b> ${project.area}</small><br>
        <small><b>Budget:</b> ${project.budget}</small><br>
        <small><b>Contractor:</b> ${project.contractor}</small>
      </div>
    `;

    marker.bindPopup(popupContent);
    
    marker.on('click', () => {
      map.setView([project.position.lat, project.position.lng], 15);
      highlightProject(project.id);
    });

    markers.push(marker);
  });
}

/* Render project list */
function renderList(data) {
  const list = document.getElementById("projects");
  list.innerHTML = "";
  
  if (document.getElementById('projectCount')) {
    document.getElementById('projectCount').textContent = data.length;
  }

  if (data.length === 0) {
    list.innerHTML = '<div style="padding: 10px; color: #9ca3af;">No projects found</div>';
    return;
  }

  data.forEach(project => {
    const div = document.createElement("div");
    div.className = "project-card";
    div.innerHTML = `
      <strong>${project.name}</strong>
      <span class="status ${project.status}">${project.status}</span><br>
      <small>${project.area}</small><br>
      <small>${project.budget} Budget</small>
    `;

    div.onclick = () => {
      map.setView([project.position.lat, project.position.lng], 15);

      const popupContent = `
        <div style="max-width:220px">
          <strong>${project.name}</strong><br>
          <small><b>Category:</b> ${project.category}</small><br>
          <small><b>Status:</b> ${project.status}</small><br>
          <small><b>Area:</b> ${project.area}</small><br>
          <small><b>Budget:</b> ${project.budget}</small><br>
          <small><b>Contractor:</b> ${project.contractor}</small>
        </div>
      `;

      const marker = markers.find(m => {
        const pos = m.getLatLng();
        return pos.lat === project.position.lat && pos.lng === project.position.lng;
      });
      
      if (marker) {
        marker.openPopup();
      }

      highlightProject(project.id);
    };

    list.appendChild(div);
  });
}

/* Highlight active project */
function highlightProject(id) {
  const project = allProjects.find(p => p.id === id);
  if (!project) return;

  document.querySelectorAll(".project-card").forEach(card => {
    card.classList.toggle("active", card.innerText.includes(project.name));
  });
}

/* Bind filter events */
function bindFilters() {
  const statusFilter = document.getElementById('statusFilter');
  const categoryFilter = document.getElementById('categoryFilter');
  const clearButton = document.getElementById('clearFilters');

  if (statusFilter) statusFilter.addEventListener('change', applyFilters);
  if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
  
  if (clearButton) {
    clearButton.addEventListener('click', () => {
      if (statusFilter) statusFilter.value = 'all';
      if (categoryFilter) categoryFilter.value = 'all';
      applyFilters();
    });
  }
}
