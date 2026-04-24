const form_ajax = document.querySelectorAll(".FormAjax"); //todos los formularios html que tengan esa clase

    function SentForm_Ajax(e) {
        e.preventDefault(); //evitar que la pagina se recargue al enviar el form al archivo del servidor
        let sent = confirm("Quieres enviar el formulario?");

        if (sent == true) {
            let dataForm = new FormData(this); //toma la data del formulario 
            let method = this.getAttribute("method"); //toma el metodo del formulario
            let action = this.getAttribute("action"); //toma la accion del formulario

            let headers = new Headers();

            let config = {
            method: method,
            headers: headers,
            mode: "cors",
            body: dataForm,
            };

            fetch(action, config)
            .then((response) => response.text())
            .then((response) => {
                let container=document.querySelector(".form-rest");
                container.innerHTML=response;
            });
        }
    }

    form_ajax.forEach((form_ajax) => {
      form_ajax.addEventListener("submit", SentForm_Ajax); //escuchando el evento submit del formulario
    });