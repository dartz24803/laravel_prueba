var app = new Vue({
  el: '#app',
  data: {
    scanner: null,
    activeCameraId: null,
    cameras: [],
    scans: []
  },
  mounted: function () {
    var self = this;
    self.scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5 });
    self.scanner.addListener('scan', function (content, image) {
      var obs=$('#observacion').val();
      var observacion=btoa(obs.normalize('NFD').replace(/[\u0300-\u036f]/g,"")); 
      window.location.href=content+"/"+observacion;
      //self.scans.unshift({ date: +(Date.now()), content: content });
    });
    Instascan.Camera.getCameras().then(function (cameras) {
      self.cameras = cameras;
     //console.log(cameras);

      if (cameras.length > 0) {
          if(cameras.length == 3){
            self.activeCameraId = cameras[2].id;
            self.scanner.start(cameras[2]);
          }else if(cameras.length == 2){
            self.activeCameraId = cameras[1].id;
            self.scanner.start(cameras[1]);
          }else if(cameras.length == 1){
            self.activeCameraId = cameras[0].id;
            self.scanner.start(cameras[0]);
          }
      } else {
        console.error('Lista de camaras no encontrada');
      }
    }).catch(function (e) {
      console.error(e);
    });
  },
  methods: {
    formatName: function (name) {
      return name || '(camara)';
    },
    selectCamera: function (camera) {
      this.activeCameraId = camera.id;
      this.scanner.start(camera);
    }
  }
});