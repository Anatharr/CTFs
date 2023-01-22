const socket = io();
const btn = document.getElementById("btn");
const canvas = document.getElementById("canvas");
const input = document.getElementById("input");


const value_keep_alive = 10
let is_streaming = false;
let stream_id = 0;
let fps = 2;

const BUFFER = [];

class message {
	constructor(cmd, value) {
		this.value = value
		this.cmd = cmd;
		this.id = Math.random().toString(36).substring(7);
	}
}

function send(msg) {
	// console.log('Sending: ', msg);
	socket.emit('private message', msg);
}

function set_resolution(res) {
	let msg = new message("setResolution", res);
	send(msg);
}

function set_camera(cam) {
	let msg = new message("setCamera", cam)
	send(msg);
	// set_resolution("192x108");
	// set_resolution("256x144");
	// set_resolution("640x360");
	set_resolution("1024x576");
	// set_resolution("1280x720");
	// set_resolution("1920x1080");
}

function get_stream() {
	let msg = new message("getStream", '');
	stream_id = msg.id;
	send(msg);
}

function stop_stream() {
	let msg = new message("stopStream", stream_id);
	send(msg);
}

function keep_alive() {
	if (!is_streaming) {
		return
	}
	let msg = new message("keepAlive", stream_id);
	send(msg);
	setTimeout(() => {
		keep_alive();
	}, value_keep_alive * 1000);
}

function draw (data) {
	var img = new window.Image();
	img.addEventListener("load", function () {
		canvas.width = img.width
		canvas.height = img.height
		canvas.getContext("2d").drawImage(img, 0, 0);
	});
	img.setAttribute("src", data);
}

function draw_buffer() {
	// console.log('Drawing buffer', BUFFER.length);
	if(is_streaming && BUFFER[0]) {
		draw(BUFFER.shift());
		setTimeout(() => {
			draw_buffer();
		}, 1000 / fps);
	} else if (is_streaming) {
		setTimeout(() => {
			draw_buffer();
		}, 1000 / fps);
	}
}

socket.on('private message', function(msg) {
	// console.log('Received: ', msg);
	if (msg.status!=undefined && msg.status.startsWith("Error")) {
		is_streaming = false;
		btn.innerHTML = 'Get stream';
	}
	else if (msg.cmd == 'sendStream' && msg.id == stream_id && !is_streaming) {
		is_streaming = true;
		BUFFER.push(msg.value);
		draw_buffer();
		keep_alive();
	}
	else if (msg.cmd == 'sendStream' && msg.id == stream_id && is_streaming) {
		BUFFER.push(msg.value);
	}
	else if(msg.cmd == 'setFPS') {
		fps = msg.value;
	}
});

btn.addEventListener('click', function(e) {
	e.preventDefault();

	if(is_streaming) {
		// console.log('Stop stream');
		is_streaming = false;
		stop_stream();
		btn.innerHTML = 'Get stream';
	} else {
		// console.log('Get stream');
		let val = input.value
		if ( val == '') {
			return
		}
		set_camera(val);
		get_stream();
		btn.innerHTML = 'Stop stream';
	}
});
