const THREE = require("three")
const fs = require('fs')
const {createCanvas} = require('./lib');

let scene, camera, renderer, rocket
const canvas = createCanvas(1920/2, 1080/2);

exports.getRenderedImage = () => {
    return canvas.toDataURL()
}

exports.setSize = (width, height) => {
    camera.aspect = width / height;
	camera.updateProjectionMatrix();

    renderer.setSize(width, height);
}

exports.init = () => {
    clock = new THREE.Clock()
    renderer = new THREE.WebGLRenderer({
        canvas,
        antialias: true,
    })

    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(55, 16/9, 1, 20000);
    camera.position.set(0, 50, 400);
    
    scene.background = new THREE.Color(0x020d1f);
    scene.fog = new THREE.Fog(0x5d0361, 10, 1500);
    const ambientLight = new THREE.HemisphereLight(0x404040, 0x404040, 1);
    
    const directionalLight = new THREE.DirectionalLight(0xdfebff, 1);
    directionalLight.position.set(-300, 0, 600);
    
    const pointLight = new THREE.PointLight(0xa11148, 2, 1000, 2);
    pointLight.position.set(200, -100, 50);
    
    scene.add(ambientLight, directionalLight, pointLight);
    
    fs.readFile('./assets/rocket.gltf.json', 'utf8' , (err, data) => {
        if (err) {
            console.error(err)
            return
        }
        rocket = new THREE.ObjectLoader().parse( JSON.parse(data) )
        rocket.position.y = 5;
        scene.add(rocket);
    })
}

const targetRocketPosition = 40;
const animationDuration = 2000;

exports.render = () => {
    // const t = clock.getElapsedTime() * 0.01
    
    // const delta = Math.sin(Math.PI * 2 * 0.5 * t);
    rocket.rotation.y += 0.5 * clock.getDelta();
    // rocket.position.y = delta;
    
    // camera.rotation.y += 0.02;
    // cameraMoved = true;

    // scene.updateMatrixWorld()
    
    // if (cameraMoved) {
    //     camera.updateMatrixWorld()
    //     cameraMoved = false;
    // }
    renderer.render(scene, camera)
}
