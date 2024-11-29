function validateJS(event, type) {
  const target = event.target;
  const parent = $(target).parent();
  let pattern;
  let errorMessage = "";

  // Determinar patrón y mensaje de error según el tipo
  switch (type) {
    case "email":
      pattern = /^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;
      errorMessage = "El correo electrónico está mal escrito";
      break;

    case "text":
      pattern = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;
      errorMessage = "El campo solo debe llevar texto";
      break;

    case "password":
      pattern = /^[*\\$\\!\\¡\\?\\¿\\.\\_\\#\\-\\0-9A-Za-z]{1,}$/;
      errorMessage = "La contraseña no puede llevar ciertos caracteres especiales";
      break;

    case "complete":
      pattern = /^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/;
      errorMessage = "La entrada tiene errores de caracteres especiales";
      break;

    case "decimal":
      pattern = /^[0-9]+(\.[0-9]{1,2})?$/; // Permite números enteros y decimales con hasta dos cifras decimales
      errorMessage = "Por favor ingrese un número válido con hasta dos decimales";
      break;

    case "integer":
      pattern = /^[0-9]+$/; // Permite solo números enteros
      errorMessage = "Por favor ingrese solo números enteros";
      break;

    case "phone":
      pattern = /^[67][0-9]{7}$/; // Comienza con 6 o 7 y seguido por 7 dígitos
      errorMessage = "Por favor ingrese un número de teléfono válido que comience con 6 o 7 y tenga 8 dígitos";
      break;

    default:
      console.warn(`Tipo de validación desconocido: ${type}`);
      return;
  }

  // Validar el campo
  if (pattern && !pattern.test(target.value)) {
    $(target).addClass("is-invalid").removeClass("is-valid");
    parent.children(".invalid-feedback").html(errorMessage);
  } else {
    // Si es válido, eliminar clases de error y añadir las de éxito
    $(target).removeClass("is-invalid").addClass("is-valid");
    parent.children(".invalid-feedback").html("");
  }
}
