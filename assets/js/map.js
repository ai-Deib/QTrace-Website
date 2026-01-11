let map;
let markers = [];
let infoWindow;

/* Quezon City center */
const QC_CENTER = { lat: 14.6760, lng: 121.0437 };

/* Quezon City boundaries */
const QC_BOUNDS = {
  north: 14.760,
  south: 14.620,
  west: 120.980,
  east: 121.120
};

/* Sample Project Data */
const PROJECTS = [
  {
    id: 1,
    name: "Batasan Hills Drainage System",
    area: "Batasan Hills, District 2",
    budget: "₱15.0M",
    status: "Ongoing",
    category: "Infrastructure",
    position: { lat: 14.682, lng: 121.091 }
  },
  {
    id: 2,
    name: "Commonwealth Avenue Road Widening",
    area: "District 6",
    budget: "₱45.0M",
    status: "Delayed",
    category: "Infrastructure",
    position: { lat: 14.676, lng: 121.060 }
  },
  {
    id: 3,
    name: "Tandang Sora Health Center Upgrade",
    area: "District 5",
    budget: "₱8.0M",
    status: "Ongoing",
    category: "Healthcare",
    position: { lat: 14.671, lng: 121.031 }
  },
  {
    id: 4,
    name: "Novaliches Elementary School Building",
    area: "District 4",
    budget: "₱25.0M",
    status: "Completed",
    category: "Education",
    position: { lat: 14.735, lng: 121.038 }
  }
];

/* Google Maps callback */
window.initMap = function () {
  const bounds = new google.maps.LatLngBounds(
    { lat: QC_BOUNDS.south, lng: QC_BOUNDS.west },
    { lat: QC_BOUNDS.north, lng: QC_BOUNDS.east }
  );

  map = new google.maps.Map(document.getElementById("map"), {
    center: QC_CENTER,
    zoom: 13,
    restriction: {
      latLngBounds: bounds,
      strictBounds: true
    },
    minZoom: 12,
    maxZoom: 18,
    mapTypeControl: false,
    fullscreenControl: false
  });

  infoWindow = new google.maps.InfoWindow();

  applyFilters();
  bindFilters();
};

/* Color by status */
function markerColor(status) {
  return {
    Planned: "blue",
    Ongoing: "green",
    Delayed: "red",
    Completed: "gray"
  }[status];
}

/* Apply filters */
function applyFilters() {
  const status = statusFilter.value;
  const category = categoryFilter.value;

  const filtered = PROJECTS.filter(p =>
    (status === "all" || p.status === status) &&
    (category === "all" || p.category === category)
  );

  renderMarkers(filtered);
  renderList(filtered);
}

/* Render markers + InfoWindow */
function renderMarkers(data) {
  markers.forEach(m => m.setMap(null));
  markers = [];

  data.forEach(project => {
    const marker = new google.maps.Marker({
      map,
      position: project.position,
      title: project.name,
      icon: `https://maps.google.com/mapfiles/ms/icons/${markerColor(project.status)}-dot.png`
    });

    marker.addListener("click", () => {
      infoWindow.setContent(`
        <div style="max-width:220px">
          <strong>${project.name}</strong><br>
          <small><b>Category:</b> ${project.category}</small><br>
          <small><b>Status:</b> ${project.status}</small><br>
          <small><b>Area:</b> ${project.area}</small><br>
          <small><b>Budget:</b> ${project.budget}</small>
        </div>
      `);

      infoWindow.open(map, marker);
      map.panTo(project.position);
      map.setZoom(15);

      highlightProject(project.id);
    });

    markers.push(marker);
  });
}

/* Project list */
function renderList(data) {
  const list = document.getElementById("projects");
  list.innerHTML = "";
  projectCount.textContent = data.length;

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
      map.panTo(project.position);
      map.setZoom(15);

      infoWindow.setContent(`
        <div style="max-width:220px">
          <strong>${project.name}</strong><br>
          <small><b>Category:</b> ${project.category}</small><br>
          <small><b>Status:</b> ${project.status}</small><br>
          <small><b>Area:</b> ${project.area}</small><br>
          <small><b>Budget:</b> ${project.budget}</small>
        </div>
      `);

      const marker = markers.find(m => m.getTitle() === project.name);
      infoWindow.open(map, marker);

      highlightProject(project.id);
    };

    list.appendChild(div);
  });
}

/* Highlight active project */
function highlightProject(id) {
  const active = PROJECTS.find(p => p.id === id).name;
  document.querySelectorAll(".project-card").forEach(card =>
    card.classList.toggle("active", card.innerText.includes(active))
  );
}

/* Bind filter events */
function bindFilters() {
  statusFilter.onchange = categoryFilter.onchange = applyFilters;

  clearFilters.onclick = () => {
    statusFilter.value = "all";
    categoryFilter.value = "all";
    applyFilters();
  };
}
