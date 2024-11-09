function modalReporter () {
    const modalCreateReport = document.getElementById("createReporter");
    const btn = document.getElementById("openCreateReporter");
    const closeBtn = modalCreateReport.getElementsByClassName("modal__close")[0];

    btn.onclick = function() {
        modalCreateReport.style.display = "block";
        document.body.classList.add("modal__open");
    }

    closeBtn.onclick = function() {
        modalCreateReport.style.display = "none";
        document.body.classList.remove("modal__open");
    }

    document.getElementById('formCreateReport').addEventListener('submit', function(event) {
        event.preventDefault();

        fetch(this.action, {
            method: this.method,
            body: new FormData(this),
        })
            .then(response => {
                if (response.ok) {
                    response.json().then(data => {
                        if (data.status === 'ok') {
                            this.reset();

                            alert("Отчет успешно создан!");

                            modalCreateReport.style.display = 'none';
                            document.body.classList.remove("modal__open");
                        }
                        if (data.status === 'error') {
                            this.reset();

                            alert("Отчет не создан!" + data.message);

                            modalCreateReport.style.display = 'none';
                            document.body.classList.remove("modal__open");
                        }
                    })
                } else {
                    alert("Произошла ошибка при отправке отчета.");
                }
            })
            .catch(error => {
                alert("Произошла ошибка при отправке отчета.");
            });
    });
}

export default modalReporter;