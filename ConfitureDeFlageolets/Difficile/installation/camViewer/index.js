const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server);
const net = require('net');
const { json } = require('express');

const PORT = 1234
const CAMERA = "/tmp/cameras/test"

var camera = null

app.use(express.static('static'));

app.get('/', (req, res) => {
    res.sendFile(__dirname + '/index.html');
});

function jsonHandler(socket, p) {
    const BUFFER = []
    let tab = p.toString().replace('}{', '}\n{').split('\n');
    tab.forEach(function(line) {
        if (line.length > 0) {
            try {
                BUFFER.push(JSON.parse(line))
            } catch (e) {
                if (e instanceof SyntaxError) {
                    socket.write(JSON.stringify({
                        status: 'Error: Invalid JSON'
                    }))
                    return;
                } else {
                    throw e;
                }
            }
        }
    });
    for (let i = 0; i < BUFFER.length; i++) {
        // console.log('From camera', BUFFER[i])
        socket.emit("private message", BUFFER[i])
    }
}

io.on('connection', (socket) => {
    console.log('Client connected');
    socket.on('private message', (msg) => {
        console.log('From client', msg)
        if (msg == undefined || msg.cmd == undefined) return;
        if (msg.cmd == "setCamera") {
            try {
                console.log('connecting to', msg.value)
                camera = net.connect(msg.value, () => {
                    socket.emit("private message", {
                        status: "success",
                        message: "Connected"
                    })
                })
                camera.on('error', (e) => {
                    socket.emit("private message", {
                        status: "error",
                        message: e
                    })
                });
            } catch (e) {
                console.error(e)
                camera = null
                return
            }
            camera.on('data', (msg) => {
                jsonHandler(socket, msg);
            })
        } else {
            if (camera != null) {
                camera.write(JSON.stringify(msg))
            } else {
              socket.emit('private message', {
                status: 'Error: Not connected'
              })
            }
        }
    })
});

server.listen(3000, () => {
    console.log('listening on *:3000');
});