const THREE = require("three")
var Sky = require("./Sky")
const {createCanvas} = require('./lib');

var angle = -5;
let scene, camera, sun, sky
let clock
const canvas = createCanvas(1920, 1080);


function updateSun(angle = 2) {
    const phi = THREE.MathUtils.degToRad(90 - angle);
    const theta = THREE.MathUtils.degToRad(180);

    sun.setFromSphericalCoords(1, phi, theta);

    sky.material.uniforms['sunPosition'].value.copy(sun);
}

exports.init = () => {
    clock = new THREE.Clock()
    renderer = new THREE.WebGLRenderer({
        canvas,
        antialias: true,
    })

    clock = new THREE.Clock()
    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(55, 16/9, 1, 20000);
    camera.position.set(0, 0, 10);

    sun = new THREE.Vector3();

    // Skybox
    sky = new Sky.Sky();
    sky.scale.setScalar(10000);
    const skyUniforms = sky.material.uniforms;
    skyUniforms['turbidity'].value = 10;
    skyUniforms['rayleigh'].value = 2;
    skyUniforms['mieCoefficient'].value = 0.005;
    skyUniforms['mieDirectionalG'].value = 0.8;
    scene.add(sky);

    updateSun();
}


let flag = 1;

exports.render = () => {
    let delta = clock.getDelta()

    angle += delta * flag;

    if (angle > 2) {
        flag = -1;
    } else if (angle < -2) {
        flag = 1;
    }

    updateSun(angle);
    renderer.render(scene, camera)
}

exports.getRenderedImage = () => {
    return canvas.toDataURL()
}

exports.setSize = (width, height) => {
    renderer.setSize(width, height)
    renderer.setPixelRatio(width / height)
}

