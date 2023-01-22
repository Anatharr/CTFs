const three = require('./rocket');
const net = require('net');
const process = require('process');


const PATH = "/tmp/cameras/test";
const FRAMERATE = 60;
const KEEPALIVE_TIMEOUT = 10;

var sendStreamTo = new Map();

// Handle incoming json and add them in a buffer
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
        handleMessage(socket, BUFFER[i]);
    }
}

function handleMessage(socket, msg) {
    if (msg == undefined || msg.cmd == undefined) {
        socket.write(JSON.stringify({
            status: "Error : Missing cmd",
            id: msg.id,
        }));
        return;
    }

    if (msg.id == undefined) {
        socket.write(JSON.stringify({
            status: "Error : Missing ID",
            id: msg.id,
        }));
        return;
    }

    if (msg.cmd == "setResolution") {
        if (msg.value != undefined) {
            const resolution = msg.value.split('x')
            if (resolution != undefined && resolution.length == 2) {
                three.setSize(parseInt(resolution[0]), parseInt(resolution[1]))
                socket.write(JSON.stringify({
                    status: "Success",
                    id: msg.id,
                }));
            }
        } else {
            socket.write(JSON.stringify({
                status: "Error : Missing value",
                id: msg.id,
            }));
        }
    }

    if (msg.cmd == "getStream") {
        socket.write(JSON.stringify({
            status: "Success",
            id: msg.id,
        }));
        socket.write(JSON.stringify({
            cmd: "setFPS",
            value: FRAMERATE,
            id: msg.id,
        }));
        sendStreamTo.set(msg.id, process.uptime());
        setTimeout(sendFrame, 1000 / FRAMERATE, socket, msg.id);
        console.log(sendStreamTo)
    }

    if (msg.cmd == "stopStream") {
        if (msg.value != undefined) {
            if (sendStreamTo.has(msg.value)) {
                sendStreamTo.delete(msg.value);
                socket.write(JSON.stringify({
                    status: "Success",
                    id: msg.id,
                }));
                console.log(sendStreamTo)
            } else {
                socket.write(JSON.stringify({
                    status: "Error : invalid ID",
                    id: msg.id,
                }));
            }

        } else {
            socket.write(JSON.stringify({
                status: "Error : Missing value",
                id: msg.id,
            }));
        }
    }

    if (msg.cmd == "keepAlive") {
        if (msg.value != undefined) {
            if (sendStreamTo.has(msg.value)) {
                sendStreamTo.set(msg.value, process.uptime())
                socket.write(JSON.stringify({
                    status: "Success",
                    id: msg.id,
                }));
            } else {
                socket.write(JSON.stringify({
                    status: "Error : invalid ID",
                    id: msg.id,
                }));
            }
        } else {
            socket.write(JSON.stringify({
                status: "Error : Missing value",
                id: msg.id,
            }));
        }
    }

    if (msg.cmd == "getStatus") {
        socket.write(JSON.stringify({
            value: "Running (uptime " + process.uptime() + ")",
            status: "Success",
        }));
    }
}

const sendFrame = (socket, id) => {
    if (sendStreamTo.has(id)) {
        if (process.uptime() - sendStreamTo.get(id) < KEEPALIVE_TIMEOUT) {
            console.log(sendStreamTo, process.uptime() - sendStreamTo.get(id))
            three.render()
            msg = {
                cmd: "sendStream",
                value: three.getRenderedImage(),
                id: id,
            }
            socket.write(JSON.stringify(msg));
            setTimeout(sendFrame, 1000 / FRAMERATE, socket, id);
        } else {
            sendStreamTo.delete(id)
        }
    }
}

const server = new net.Server();
server.listen(PATH, function() {
    console.log(`Listening on ${PATH}`);
});

server.on('connection', function(socket) {
    console.log('Connection established.');

    socket.on('data', (msg) => {
        console.log(msg.toString());
        jsonHandler(socket, msg);
    });

    socket.on('end', function() {
        console.log('Closing connection with the client');
    });

    socket.on('error', function(err) {
        console.log(`Error: ${err}`);
    });
});

three.init();