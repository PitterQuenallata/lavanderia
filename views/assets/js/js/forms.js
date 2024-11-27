function validateJS(event, type) {
  $(event.target).parent().addClass("was-validated");

  if (type == "email") {
    var pattern = /^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;
    if (!pattern.test(event.target.value)) {
      $(event.target).parent().children(".invalid-feedback").html("El correo electrónico está mal escrito");
      event.target.value = "";
      return;
    }
  }

  if (type == "text") {
    var pattern = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;
    if (!pattern.test(event.target.value)) {
      $(event.target).parent().children(".invalid-feedback").html("El campo solo debe llevar texto");
      event.target.value = "";
      return;
    } else {
      // Llama a la función de verificación solo si la validación de texto es exitosa
      if (event.target.id === "nuevoNombreRepuesto") {
      
      }
    }
  }

  if (type == "password") {
    var pattern = /^[*\\$\\!\\¡\\?\\¿\\.\\_\\#\\-\\0-9A-Za-z]{1,}$/;
    if (!pattern.test(event.target.value)) {
      $(event.target).parent().children(".invalid-feedback").html("La contraseña no puede llevar ciertos caracteres especiales");
      event.target.value = "";
      return;
    }
  }

  if (type == "complete") {
    var pattern = /^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/;
    if (!pattern.test(event.target.value)) {
      $(event.target).parent().children(".invalid-feedback").html("La entrada tiene errores de caracteres especiales");
      event.target.value = "";
      return;
    } else {
      // Llama a la función de verificación solo si la validación de texto es exitosa
      if (event.target.id === "nuevoNombreRepuesto") {
        verificarRepuesto(); // Esta función debe estar definida en repuestos.js
      }
    }
  }

  if (type == "decimal") {
    var pattern = /^[0-9]+(\.[0-9]{1,2})?$/; // Permite números enteros y decimales con hasta dos cifras decimales
    if (!pattern.test(event.target.value)) {
      $(event.target).parent().children(".invalid-feedback").html("Por favor ingrese un número válido con hasta dos decimales");
      event.target.value = "";
      return;
    }
  }

  if (type == "integer") {
    var pattern = /^[0-9]+(\.[0-9]{1,2})?$/; // Permite números enteros y decimales con hasta dos cifras decimales
    if (!pattern.test(event.target.value)) {
      $(event.target).parent().children(".invalid-feedback").html("Por favor ingrese solo números");
      event.target.value = "";
      return;
    }
  }

  if (type == "phone") {
    var pattern = /^[67][0-9]{7}$/; // Comienza con 6 o 7 y seguido por 7 dígitos
    if (!pattern.test(event.target.value)) {
      $(event.target).parent().children(".invalid-feedback").html("Por favor ingrese un número de teléfono válido que comience con 6 o 7 y tenga 8 dígitos");
      event.target.value = "";
      return;
    }
  }

  
}