/*=============================================
Formatear envío de formulario lado servidor
=============================================*/

function fncFormatInputs() {
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
}

/*=============================================
Alerta Notie
=============================================*/

function fncNotie(type, text) {
  notie.alert({
    type: type,
    text: text,
    time: 10,
  });
}

/*=============================================
Alerta SweetAlert
=============================================*/
function fncSweetAlert(type, text, url, callback) {
  switch (type) {
    case "error":
      if (url == "") {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: text,
        }).then((result) => {
          if (callback) callback(result);
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: text,
        }).then((result) => {
          if (result.value) {
            window.open(url, "_top");
          }
        });
      }
      break;

    case "success":
      if (url == "") {
        Swal.fire({
          icon: "success",
          title: "Correcto",
          text: text,
        }).then((result) => {
          if (callback) callback(result);
        });
      } else {
        Swal.fire({
          icon: "success",
          title: "Correcto",
          text: text,
        }).then((result) => {
          if (result.value) {
            window.open(url, "_top");
          }
        });
      }
      break;

    case "loading":
      Swal.fire({
        allowOutsideClick: false,
        icon: "info",
        text: text,
      });
      Swal.showLoading();
      break;

      case "confirm":
        return new Promise((resolve) => {
          Swal.fire({
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "No",
            confirmButtonText: "Sí, continuar!",
          }).then(function (result) {
            if (result.isConfirmed && url) {
              // Si el usuario confirma y hay una URL, redirige
              window.location.href = url;
            }
            resolve(result);
          });
        });
        break;
     
    case "delete":
      return new Promise((resolve) => {
        Swal.fire({
          text: text,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "No",
          confirmButtonText: "Sí, eliminar!",
        }).then(function (result) {
          resolve(result.isConfirmed);
        });
      });
      break;
  }
}


/*=============================================
Alerta Toast
=============================================*/
// Tu función fncToastr
function fncToastr(type, text) {
  var bgColor;
  var heading;
  var icon;

  switch (type) {
    case "success":
      icon = "success";
      heading = "Correcto";
      break;
    case "error":
      icon = "error";
      heading = "Error";
      break;
    case "info":
      bgColor = "#5bc0de"; // Color azul para información
      heading = "Informacion";
      icon = "info";
      break;
    case "warning":
      heading = "Warning";
      icon = "warning";
      break;
    default:
      bgColor = "#5bc0de";
      heading = "Notification";
  }

  $.toast({
    text: text,
    heading: heading,
    showHideTransition: "plain",
    position: "top-right",
    bgColor: bgColor,
		icon: icon,
    allowToastClose: true,
    hideAfter: 5000,
    stack: 5,
  });
}


/*=============================================
Alerta Línea Precarga
=============================================*/

function fncMatPreloader(type) {
  var preloader = new $.materialPreloader({
    position: "top",
    height: "5px",
    col_1: "#159756",
    col_2: "#da4733",
    col_3: "#3b78e7",
    col_4: "#fdba2c",
    fadeIn: 200,
    fadeOut: 200,
  });

  if (type == "on") {
    preloader.on();
  }

  if (type == "off") {
    $(".load-bar-container").remove();
  }
}
