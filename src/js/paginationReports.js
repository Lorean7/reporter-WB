function paginationReporters() {
    const modalShowReports = document.getElementById("showReports");
    const closeBtn = modalShowReports.getElementsByClassName('show-modal__close')[0];
    const btn = document.getElementById("openShowReports");
    const form = document.getElementById("formFetchReports");

    const reportsPerPage = 10;
    let currentPage = 1;

    btn.onclick = function() {
        modalShowReports.style.display = "block";
        document.body.classList.add("modal__open");
    }

    closeBtn.onclick = function() {
        modalShowReports.style.display = "none";
        document.body.classList.remove("modal__open");
    }

    $('.table__body').on('click', '.button--edit', function (){
        const id =  ($(this).data('id_reports'));

        const $reportsWrapper = $('.reportsWrapper');
        const $editReport = $('.edit-report');
        const $buttonEditHide = $('.button-hide-edit');

        // Показываем элементы
        $reportsWrapper.addClass('reportsWrapper__hide');
        $editReport.addClass('edit-report__show');
        $buttonEditHide.addClass('button-hide-edit__show');

        // Обработчик для кнопки "Скрыть"
        $buttonEditHide.on('click', function () {
            // Скрываем элементы
            $reportsWrapper.removeClass('reportsWrapper__hide');
            $editReport.removeClass('edit-report__show');
            $buttonEditHide.removeClass('button-hide-edit__show');
        });

        const url = new URL("http://lorean.local/database/getReport.php")
        url.searchParams.append('id',id)

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const id = data.report.id
                    const box_number = data.report.box_number
                    const date_create = data.report.date_create
                    const product_count = data.report.product_count
                    const time_close = data.report.time_close.split(':').slice(0,2).join(':')
                    const worker = data.report.worker
                    const comment = data.report.comment

                    $('#id').val(id)
                    $('#create_date').val(date_create)
                    $('#box_number').val(box_number)
                    $('#product_count').val(product_count)
                    $('#time_close').val(time_close)
                    $('#worker').val(worker)
                    $('#comment').val(comment)
                }
            })

        const editUrl = new URL('http://lorean.local/database/editReports.php')

        $('#editReport').on('submit', function (e) {
            e.preventDefault();

            fetch(editUrl, {
                method: this.method,
                body: new FormData(this),
            })
                .then(response => {
                    return response.json()
                })
                .then(data => {
                    console.log(data)
                    if (data.status === 'success') {
                        alert(`Отчет был успешно перезаписан`)
                        $('.button-hide-edit').click();
                        fetchReports(currentPage);

                    } else {
                        alert(`'Ошибка: ${data.message}`)
                    }
                })
        })
    });


    $('.table__body').on('click', '.button--delete', function (){
        const id = $(this).data('id_reports');


        const url = new URL('http://lorean.local/database/deleteReports.php');
        url.searchParams.append('id', id);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(`Отчет был успешно удален.`)
                    const parentRow = $(this).parent().parent().remove()
                    fetchReports(currentPage);
                } else {
                    alert(`'Ошибка: ${data.message}`)
                }
            })
    })

    function getFormData() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        return { start_date: startDate, end_date: endDate };
    }

    function fetchReports(page) {
        const { start_date, end_date } = getFormData();

        const pagination = $('.pagination');
        pagination.empty();

        const url = new URL('http://lorean.local/database/fetchReports.php');
        url.searchParams.append('page', page);
        url.searchParams.append('start_date', start_date);
        url.searchParams.append('end_date', end_date);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.data.length > 0) {
                    $('.table__marker-not-data').css('display', 'none')
                    renderReports(data.data);
                    renderPagination(data.total, page);
                }else {
                    $('.table__marker-not-data').html(`Данные c ${start_date} ${end_date ? 'по ' + end_date : ''} отсутствуют`);
                    $('.table__marker-not-data').css('display', 'flex')
                    $('.table__body').empty();
                    $('.pagination').empty();

                    $('.button-delete-reports').css('display','none')
                    $('.button-create-excel').css('display','none')
                }
            })
            .catch(error => console.error('Error fetching reports:', error));
    }

    function renderReports(reports) {
        const { start_date, end_date } = getFormData();
        const reportsBody = $('.table__body');
        reportsBody.data('start_date', start_date);
        reportsBody.data('end_date', end_date);


        reportsBody.empty();


        const $btnDeleteAll = $('.button-delete-reports')[0]
        const $btnCreateExcel = $('.button-create-excel')[0]

        if (reports.length) {
            $btnDeleteAll.style.display = 'flex'
            $btnCreateExcel.style.display = 'flex'
        }else {
            $btnDeleteAll.style.display = 'none'
            $btnCreateExcel.style.display = 'none'
        }

        reports.forEach(report => {
            const row = document.createElement('tr');
            row.className = 'table__row';
            const $button_edit = ` <button data-id_reports="${report.id}" class="button button--edit">Изменить</button>`
            const $button_delete = `<button data-id_reports="${report.id}" class="button button--delete">Удалить</button>`

            row.innerHTML = `
                <td class="table__data" id="id-reports" data-id="${report.id}">${report.id}</td>
                <td class="table__data">${report.date_create}</td>
                <td class="table__data">${report.box_number}</td>
                <td class="table__data">${report.product_count}</td>
                <td class="table__data">${report.time_close}</td>
                <td class="table__data">${report.worker}</td>
                <td class="table__data">${report.comment}</td>
                <td class="table__data">
                ${$button_edit}
                ${$button_delete}
                </td>
            `;
            reportsBody.append(row);

        });
    }

    function renderPagination(total, currentPage) {
        const paginationDiv = document.getElementById('pagination');
        paginationDiv.innerHTML = '';

        for (let i = 1; i <= Math.ceil(total / reportsPerPage); i++) {
            const link = document.createElement('a');
            link.className = `pagination__link ${i === currentPage ? 'pagination__link--active' : ''}`;
            link.href = '#';
            link.innerText = i;
            link.onclick = (e) => {
                e.preventDefault();
                currentPage = i;
                fetchReports(currentPage);
            };
            paginationDiv.appendChild(link);
        }
    }

    form.onsubmit = function(event) {
        event.preventDefault();
        fetchReports(1);
    }

    $('.button-delete-reports').on('click', function () {

        const reportsBody = $('.table__body');
        const pagination = $('.pagination');
        const btnAllDelete = $('.button-delete-reports');
        const btnCreateReport = $('.button-create-excel');

        let start_date = reportsBody.data('start_date');
        let end_date = reportsBody.data('end_date');


        const url = new URL('http://lorean.local/database/deleteAllReports.php')
        url.searchParams.append('start_date', start_date);
        url.searchParams.append('end_date', end_date);

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'charset': 'utf8',
            },
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Ошибка сети');
                }

                return response.json()
            })
            .then(data => {
                if (data.status === 'success') {
                    reportsBody.empty();
                    pagination.empty();
                    btnAllDelete[0].style.display = 'none';
                    btnCreateReport[0].style.display = 'none';

                    alert('Записи успешно удалены');
                }
            })
            .catch(error => {
                alert(`Произошла ошибка: ${error.message}`);
            });
    })

    document.getElementById('start_date').addEventListener('change', function() {
        const startDate = this.value;

        const endDateInput = $('#end_date');
        endDateInput.attr('min', startDate)
        endDateInput.val('');

        if (startDate) {
            endDateInput.prop('disabled', false);

            $('#end_date').attr('min', startDate);
        } else {
            endDateInput.prop('disabled', true);
        }
    });

}

export default paginationReporters;
