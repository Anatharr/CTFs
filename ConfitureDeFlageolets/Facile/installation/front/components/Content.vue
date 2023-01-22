<template>
  <body>

    <div class="flex flex-row py-16 h-1/5">
        <div class="flex flex-col w-2/5 pt-32 pl-24">
            <h1 class="text-8xl m-8 text-center">Bienvenue sur STDoctoLib</h1>
                <p class="text-xl my-2">{{message}}</p>
                <div class="mx-auto flex flex-col">
                        <v-select v-if="!flag" :options="sortedMedecines" label="nom" placeholder="Médecine recherchée" class="w-96 m-1 text-gray-600 dark:text-gray-400 text-lg"></v-select>
                        <v-select v-if="!flag" @search="onChange" :value="citySearched" @input="onInput" :options="fetchedcity" label="nom" placeholder="Ville" class="w-96 m-1 text-gray-600 dark:text-gray-400 text-lg"></v-select>
                    <button v-if="!flag" @click="changeMessage" class="h-12 mx-4 mt-2 bg-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 text-white px-8 text-sm focus:outline-none focus:ring-2 cursor-pointer focus:ring-indigo-600 rounded border shadow">Rechercher
                    </button>
                    <a v-else href="http://www.doctolib.fr" class="h-12 mx-4 mt-2 bg-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 text-white text-center items-center pt-3 px-8 text-sm focus:outline-none focus:ring-2 cursor-pointer focus:ring-indigo-600 rounded border shadow">Aller sur Doctolib
                    </a>
                </div>
        </div>
        <div id="container" class="w-1/5 h-auto">
            <canvas id="ThreeCanvas"></canvas>
        </div>
        <img class="w-2/5" src="~/assets/bg_head3.png"/>
    </div>


    <div class="grid grid-rows-7 grid-col-4 gap-4 w-4/6 m-auto h-auto">
        <div class="row-span-1 col-span-4 text-center text-4xl my-8 font-bold">Vous connaissez STDoctoLib ?</div>

        <div class="row-span-1 col-span-1 text-center px-4 text-gray-600 text-2xl font-bold">STDoctoLib c'est...</div>
        <div class="row-span-1 col-span-1 text-center px-8"><strong class="font-bold text-2xl">{{Math.floor(Math.random()*12+2)}} millions<br></strong> de professionnels de santé.</div>
        <div class="row-span-1 col-span-1 text-center px-8"><strong class="font-bold text-2xl">{{Math.floor(Math.random()*50000+2)}}<br></strong>personnels de santé.</div>
        <div class="row-span-1 col-span-1 text-center px-8"><strong class="font-bold text-2xl">{{Math.floor(Math.random()*100)}}% d'avis<br></strong>négatifs.</div>

        <div class="row-span-1 col-span-4 text-center text-4xl font-bold my-8">Pourquoi prendre rendez-vous chez STDoctoLib ?</div>

        <img class="row-span-3 col-span-1 h-64 w-64 m-auto" src="~/assets/1.png"/>
        <img class="row-span-3 col-span-1 h-64 w-64 m-auto" src="~/assets/2.png"/>
        <img class="row-span-3 col-span-1 h-64 w-64 m-auto" src="~/assets/3.png"/>
        <img class="row-span-3 col-span-1 h-64 w-64 m-auto" src="~/assets/4.png"/>

        <div class="row-span-1 col-span-1 text-center px-8">Accédez aux disponibilités de <strong class="font-bold">dizaines de milliers de professionnels</strong> de santé.</div>
        <div class="row-span-1 col-span-1 text-center px-8">Prenez rendez vous en ligne, <strong class="font-bold">24h/24 et 7j/7</strong>, pour une consultation physique ou vidéo.</div>
        <div class="row-span-1 col-span-1 text-center px-8">Recevez des <strong class="font-bold">rappels automatiques</strong> par SMS ou par email.</div>
        <div class="row-span-1 col-span-1 text-center px-8">Retrouvez votre <strong class="font-bold">historique de rendez-vous</strong> et vos <strong class="font-bold">documents médicaux</strong>.</div>
    </div>

</body>
</template>

<script>
export default {
    mounted() {
        init();   
        animate()
    },
    data() {
        return {
            citySearched: '',
            medecines: [
                { nom: 'Medecin homéopatique' },
                { nom: 'Lithotérapeute' },
                { nom: 'Astrologue' },
                { nom: 'Clément Mellier' },
                { nom: 'Acupuncteur' },
                { nom: 'Apithérapeute' },
                { nom: 'Magnétisme animal' },
                { nom: 'Balnéothérapeute' },
                { nom: 'Earthing / Grounding' },
                { nom: 'Electrohoméopate' },
                { nom: 'Médecine énergétique' },
                { nom: 'Guérison par la foi' },
                { nom: 'Analyse Capilaire' },
                { nom: 'Eau hexagonale'},
                { nom: 'Iridologie'},
                { nom: 'Magnet thérapie'},
                { nom: 'Naturopathe'},
                { nom: 'Médecine orthomoléculaire'},
                { nom: 'Médecine chinoise traditionnelle'},
                { nom: 'Thérapie urinaire'},
                { nom: 'Vitalisme'}
            ],
            fetchedcity: [],
            message: 'Prenez rendez-vous rapidement avec un de nos professionnels de santé:',
            flag: false
        }
    },
    computed: {
        sortedMedecines() {
            return this.medecines.sort((a, b) => a.nom.localeCompare(b.nom))
        }
    },
    beforeDestroy() {
        cancelAnimationFrame(ID);
    },
    methods: {
        onChange(newval) {
            if (newval) {
                this.citySearched = newval;
                this.$fetch()
            }
        },
        onInput(data) {
            if(data) {
                this.citySearched = data.nom;
            }
        },
        changeMessage() {
            this.message = 'Si vous avez un problème de santé, veuillez contacter un vrai professionnel de santé, sur le site Doctolib. Pas une pseudoscience.'
            this.flag = true
        },
    },
    async fetch() {
        this.fetchedcity = await this.$axios.$get(`https://geo.api.gouv.fr/communes/?nom=${this.citySearched}&fields=departement&boost=population&limit=5`)
    }
}

import * as THREE from "three" 
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

let scene, camera, renderer, canvas, clock, controls
let ID
const loader = new GLTFLoader();



function loadEnd() {
    // canvas.style.zIndex = -1
}

function init() {
    scene = new THREE.Scene()
    clock = new THREE.Clock


    console.log("Paix et amour sur Clément Mellier")

    canvas = document.getElementById("ThreeCanvas")
    let size = document.getElementById("container")

    canvas.width = size.clientWidth
    canvas.style.width = size.clientWidth
    canvas.height = size.clientHeight
    canvas.style.height = size.clientHeight


    camera = new THREE.PerspectiveCamera(75, canvas.width / canvas.height, 0.001, 100)
    camera.position.z = 8
    camera.position.y = 0



    renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true })
        // renderer.setPixelRatio(canvas.width / canvas.height)
    renderer.setSize(canvas.width, canvas.height)

    controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true; // an animation loop is required when either damping or auto-rotation are enabled
    controls.dampingFactor = 0.02;

    controls.screenSpacePanning = false;
    controls.enablePan = false;
    controls.enableZoom = false;

    // controls.minDistance = 0;
    // controls.maxDistance = 500;

    controls.minPolarAngle = Math.PI / 2;
    controls.maxPolarAngle = Math.PI / 2;

    loader.load(
	// resource URL
    'syringe.glb',

	// called when the resource is loaded
	function ( gltf ) {

        gltf.scene.rotation.z = Math.PI / 2 - 0.15
        gltf.scene.position.y -= 2.5
		scene.add( gltf.scene );

		gltf.animations; // Array<THREE.AnimationClip>
		gltf.scene; // THREE.Group
		gltf.scenes; // Array<THREE.Group>
		gltf.cameras; // Array<THREE.Camera>
		gltf.asset; // Object

	},
	// called while loading is progressing
	function ( xhr ) {


	},
	// called when loading has errors
	function ( error ) {


	}
);

    let mesh = new THREE.Mesh(
        new THREE.BoxGeometry(1, 2),
        new THREE.MeshBasicMaterial({ color: 0xff0000 })
    )
    mesh.scale.set(0.008, 0.008, 0.008)
    // scene.add(mesh)

    window.addEventListener(
        'resize',
        () => {
            camera.aspect = canvas.width / canvas.height
            camera.updateProjectionMatrix()
            renderer.setSize(canvas.width, canvas.height)
            render()
        },
        false
    )
    loadEnd()

}



function animate() {
    controls.update()
    ID = requestAnimationFrame(animate)
    var t = clock.getElapsedTime()
    if (scene.children.length > 0) {
        scene.children.forEach(element => {
            element.rotation.y = t * 0.4
                // element.rotation.y += 0.1 * clock.getDelta()
        });
    }

    render()
}

function render() {
    renderer.render(scene, camera)
}

</script>

<style>

</style>