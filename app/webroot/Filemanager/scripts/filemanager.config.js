/*---------------------------------------------------------
  Configuration
---------------------------------------------------------*/

// Set culture to display localized messages
var culture = 'en';

// Set default view mode : 'grid' or 'list'
var defaultViewMode = 'grid';

// Autoload text in GUI - If set to false, set values manually into the HTML file
var autoload = true;

// Display full path - default : false
var showFullPath = false;

// Browse only - default : false
var browseOnly = true;

// Set this to the server side language you wish to use.
var lang = 'php'; // options: php, jsp, lasso, asp, cfm, ashx, asp // we are looking for contributors for lasso, python connectors (partially developed)

var am = document.location.pathname.substring(1, document.location.pathname.lastIndexOf('/') + 1);

// Set this to the directory you wish to manage.
var fileRoot = '/files/';

//Path to the manage directory on the HTTP server
var relPath = window.location.protocol + '//' + document.domain;

// Show image previews in grid views?
var showThumbs = true;

// Allowed image extensions when type is 'image'
var imagesExt = ['jpg', 'jpeg', 'gif', 'png'];

// Videos player support
// -----------------------------------------
var showVideoPlayer = false;
var videosExt = ['ogv', 'mp4', 'webm']; // Recognized videos extensions
var videosPlayerWidth = 400; // Videos Player Width
var videosPlayerHeight = 222; // Videos Player Height

// Audios player support
//-----------------------------------------
var showAudioPlayer = false;
var audiosExt = ['ogg', 'mp3', 'wav']; // Recognized audios extensions