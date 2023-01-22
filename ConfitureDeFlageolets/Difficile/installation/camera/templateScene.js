var THREE = require("three")

exports.init = () => {
    clock = new THREE.Clock()
    exports.scene = scene = new THREE.Scene();


}

exports.render = () => {
    let delta = clock.getDelta()


    scene.updateMatrixWorld()
}

exports.scene = scene;