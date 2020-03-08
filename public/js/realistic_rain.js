let scene,
  camera,
  renderer,
  cloudParticles = [],
  flash,
  rain,
  rainGeo,
  rainCount = 15000;
function init() {
  scene = new THREE.Scene();
  camera = new THREE.PerspectiveCamera(
    60,
    window.innerWidth / window.innerHeight,
    1,
    1000
  );
  camera.position.z = 1;
  camera.rotation.x = 1.16;
  camera.rotation.y = -0.12;
  camera.rotation.z = 0.27;
  ambient = new THREE.AmbientLight(0x555555);
  scene.add(ambient);
  directionalLight = new THREE.DirectionalLight(0xffeedd);
  directionalLight.position.set(0, 0, 1);
  scene.add(directionalLight);
  flash = new THREE.PointLight(0x062d89, 30, 500, 1.7);
  flash.position.set(200, 300, 100);
  scene.add(flash);
  renderer = new THREE.WebGLRenderer();
  scene.fog = new THREE.FogExp2(0x11111f, 0.002);
  renderer.setClearColor(scene.fog.color);
  renderer.setSize(window.innerWidth, window.innerHeight);
  document.body.appendChild(renderer.domElement);
  rainGeo = new THREE.Geometry();
  for (let i = 0; i < rainCount; i++) {
    rainDrop = new THREE.Vector3(
      Math.random() * 400 - 200,
      Math.random() * 500 - 250,
      Math.random() * 400 - 200
    );
    rainDrop.velocity = {};
    rainDrop.velocity = 0;
    rainGeo.vertices.push(rainDrop);
  }
  rainMaterial = new THREE.PointsMaterial({
    color: 0xaaaaaa,
    size: 0.1,
    transparent: true
  });
  rain = new THREE.Points(rainGeo, rainMaterial);
  scene.add(rain);
  let loader = new THREE.TextureLoader();
  loader.load("../assets/smoke.png", function(texture) {
    cloudGeo = new THREE.PlaneBufferGeometry(500, 500);
    cloudMaterial = new THREE.MeshLambertMaterial({
      map: texture,
      transparent: true
    });
    for (let p = 0; p < 25; p++) {
      let cloud = new THREE.Mesh(cloudGeo, cloudMaterial);
      cloud.position.set(
        Math.random() * 800 - 400,
        500,
        Math.random() * 500 - 450
      );
      cloud.rotation.x = 1.16;
      cloud.rotation.y = -0.12;
      cloud.rotation.z = Math.random() * 360;
      cloud.material.opacity = 0.6;
      cloudParticles.push(cloud);
      scene.add(cloud);
    }
    audios();
    animate();
  });
}
function animate() {
  cloudParticles.forEach(p => {
    p.rotation.z -= 0.002;
  });
  rainGeo.vertices.forEach(p => {
    p.velocity -= 0.1 + Math.random() * 0.1;
    p.y += p.velocity;
    if (p.y < -200) {
      p.y = 200;
      p.velocity = 0;
    }
  });
  rainGeo.verticesNeedUpdate = true;
  rain.rotation.y += 0.002;
  if (Math.random() > 0.93 || flash.power > 100) {
    if (flash.power < 100)
      flash.position.set(Math.random() * 400, 300 + Math.random() * 200, 100);
    flash.power = 50 + Math.random() * 500;
  }
  renderer.render(scene, camera);
  requestAnimationFrame(animate);
}

function audios() {
  // create an AudioListener and add it to the camera
  var listener = new THREE.AudioListener();
  camera.add(listener);

  // create a global audio source
  var sound = new THREE.Audio(listener);
  if (!sound.isPlaying) {
    // load a sound and set it as the Audio object's buffer
    var audioLoader = new THREE.AudioLoader();
    audioLoader.load("../assets/rain-01.mp3", function(buffer) {
      sound.setBuffer(buffer);
      sound.setLoop(true);
      sound.setVolume(0.5);

      const body = document.body;
      document.addEventListener("click", function() {
        sound.play();
      });
      //body.click();
    });

    // create an AudioListener and add it to the camera
    var listener1 = new THREE.AudioListener();
    camera.add(listener1);

    var sound1 = new THREE.Audio(listener1);

    // load a sound and set it as the Audio object's buffer
    var audioLoader1 = new THREE.AudioLoader();
    audioLoader1.load("../assets/thunder.mp3", function(buffer) {
      sound1.setBuffer(buffer);
      sound1.setLoop(false);
      sound1.setVolume(0.9);
      document.addEventListener("click", function() {
        setInterval(() => {
          sound1.play();
        }, 30000);
      });
    });
  }
}
init();
