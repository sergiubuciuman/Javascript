<script>
var infowindow;
var contentString;

var markersArray = [];

var map,i;

//	Initializes the map with a marker
function initMap() {
    var sample = [{}, {}, {} /*, ... */];
	var myLatLng = [{
		lat: -25.363,
		lng: 131.044
	},{ lat: -25,
		lng: 131},
	  { lat: -25.7,
		lng: 131.2}];

	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 4,
		center: myLatLng[0]
	});

	// This event listener calls addMarker() when the map is clicked.
	google.maps.event.addListener(map, 'click', function(event) {
		addMarker(event.latLng);
	});
    for(i=0;i<3;i++)
	addMarker(myLatLng[i]);
}

// Adds a marker to the map and push to the array.
function addMarker(location) {
    var index = markersArray.length;
	var marker = new google.maps.Marker({
		position: location,
		map: map,
		draggable: true,
		animation: google.maps.Animation.DROP,
		label: index + "",
		title: index + ""
	});
	markersArray.push(marker);
	marker.addListener('click', function() {
		clickMarkerEvent(index);
	});
	console.log(index);
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
	for (var i = 0; i < markersArray.length; i++) {
		setMapOnMarker(i, map);
	}
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
	setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
	setMapOnAll(map);
}

function setMapOnMarker(markerIndex, map) {
	markersArray[markerIndex].setMap(map);
}
function setColorMarker(markerIndex, map) {
	markersArray[markerIndex].setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
}

function hideMarker(markerIndex) {
	setMapOnMarker(markerIndex, null);
}
function ChangeColorMarker(markerIndex) {
	setColorMarker(markerIndex, null);
}

function deleteMarker(markerIndex) {
	hideMarker(markerIndex);
	markersArray[markerIndex] = null;
}


function deleteMarkers() {
	clearMarkers();

	for (var i = 0; i < markersArray.length; i++) {
		markersArray[i] = null;
	}

	markersArray = [];
}

//listeners
function clickMarkerEvent(index) {

	if (markersArray[index].getAnimation() !== null) {
		markersArray[index].setAnimation(null);
	}
	else {
		markersArray[index].setAnimation(google.maps.Animation.BOUNCE);
	}
	
	contentString = '<div id="content">' +
	'<div id="siteNotice">' +
	'</div>' +
	'<h1 id="firstHeading" class="firstHeading">Marker Info</h1>' +
	'<div id="bodyContent">' +
	'<b>Locatoin:</b> <p>' + markersArray[index].getPosition() + '</p>' + 
	'<b>Title: </b> <p>' + markersArray[index].getTitle() + '</p>' + 
	'<img src="img1.jpg" alt="Smiley face" height="152" width="102">'+
	'<button onclick="changeMarkerColorClickEvent(' + index + ')">Change Color</button>' +
	'<button onclick="deleteMarkerClickEvent(' + index + ')">Delete Marker</button>' +
	'</div>' +
	'</div>';
	
	if(infowindow !== null && typeof infowindow !== 'undefined')
		infowindow.close();
	
	infowindow = new google.maps.InfoWindow({
		content: contentString,
		maxWidth: 200
	});
	infowindow.open(map, markersArray[index]);
}

function deleteMarkerClickEvent(index) {
	deleteMarker(index);
}

function changeMarkerColorClickEvent(index) {
	ChangeColorMarker(index);
}
</script>