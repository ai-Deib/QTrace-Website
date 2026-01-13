// Initialize the Map
const map = L.map('map', {
    center: [14.6760, 121.0437], // Quezon City Coordinates
    zoom: 13,
    scrollWheelZoom: true
});

// 2. Add OpenStreetMap Tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

const markerLayer = L.layerGroup().addTo(map);

// 3. Status Color Mapping
function getStatusColor(status) {
    const colors = {
        'Planned': '#0d6efd',   // Blue
        'Ongoing': '#198754',   // Green
        'Delayed': '#dc3545',   // Red
        'Completed': '#6c757d'  // Gray
    };
    return colors[status] || '#333';
}

// 4. Main Render Function
function renderMap(data) {
    const listArea = document.getElementById('projectList');
    const countLabel = document.getElementById('projectCount');
    
    // Clear previous items
    listArea.innerHTML = '';
    markerLayer.clearLayers();
    countLabel.innerText = data.length;

    data.forEach(proj => {
        // Create Sidebar List Item
        const item = document.createElement('div');
        item.className = 'project-item p-3 border-bottom';
        item.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
                <span class="fw-bold small">${proj.name}</span>
                <span class="badge" style="background-color: ${getStatusColor(proj.status)}; font-size: 0.7rem;">${proj.status}</span>
            </div>
            <div class="text-muted small mt-1"><i class="bi bi-geo-alt"></i> ${proj.location}</div>
        `;
        
        // Fly to location on click
        item.onclick = () => {
            map.flyTo([proj.lat, proj.lng], 16);
            openProjectPopup(proj);
        };
        listArea.appendChild(item);

        // CREATE BOOTSTRAP ICON PIN
        const pinIcon = L.divIcon({
            html: `<i class="bi bi-geo-alt-fill" style="color: ${getStatusColor(proj.status)};"></i>`,
            className: 'custom-pin', // Uses the CSS we added to the PHP file
            iconSize: [30, 30],
            iconAnchor: [15, 30],   // Points the bottom tip of the pin to the lat/lng
            popupAnchor: [0, -32]   // Positions popup above the pin
        });

        // Add Marker to Map
        L.marker([proj.lat, proj.lng], { icon: pinIcon })
            .addTo(markerLayer)
            .on('click', () => openProjectPopup(proj));
    });
}

// 5. Popup Function
function openProjectPopup(proj) {
    const content = `
        <div class="p-2" style="min-width: 200px;">
            <h6 class="fw-bold mb-1">${proj.name}</h6>
            <p class="text-muted mb-2 small">${proj.location}</p>
            <hr class="my-2">
            <div class="small mb-1"><strong>Budget:</strong> ${proj.budget}</div>
            <button class="btn btn-primary btn-sm w-100 fw-bold">View Full Details</button>
        </div>
    `;
    L.popup()
        .setLatLng([proj.lat, proj.lng])
        .setContent(content)
        .openOn(map);
}

// 6. Filter Listeners
function applyFilters() {
    const s = document.getElementById('statusFilter').value;
    const c = document.getElementById('categoryFilter').value;
    
    const filtered = projects.filter(p => {
        const statusMatch = (s === 'all' || p.status === s);
        const categoryMatch = (c === 'all' || p.category === c);
        return statusMatch && categoryMatch;
    });
    renderMap(filtered);
}

document.getElementById('statusFilter').addEventListener('change', applyFilters);
document.getElementById('categoryFilter').addEventListener('change', applyFilters);
document.getElementById('clearFilters').addEventListener('click', () => {
    document.getElementById('statusFilter').value = 'all';
    document.getElementById('categoryFilter').value = 'all';
    renderMap(projects);
});

// Initial Load
renderMap(projects);