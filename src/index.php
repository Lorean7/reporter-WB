<?php
$project_name = getenv('PROJECT_NAME');
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="public/css/main.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
</head>
    <body>
        <div class="footer">
            <div class="name-project">
                <?= $project_name ?>
            </div>
            <div class="active-option">
                Расписание сотрудников
                <div class="dropdown">
                    <div class="dropdown-item">Редактировать расписание</div>
                </div>
            </div>
            <div class="active-option">
                Отчеты
                <div class="dropdown">
                    <div class="dropdown-item" id="openCreateReporter">Создать отчет</div>
                    <div class="dropdown-item" id="openShowReports">Просмотреть все отчеты</div>
                </div>
            </div>
        </div>
        <div class="screen-wrapper">
            <div class="screen-default screen-default--show">
                <div class="screen-default__title">
                    Добро пожаловать!!!
                    Данный инструмент поможет вам автоматизировать ваш рабочий процесс
                </div>
            </div>
            <div class="screen-report screen-report--hidden">
                <div class="screen-default__title">
                    Отчеты
                </div>
            </div>
        </div>
        <!-- Модалки       -->
        <div id="createReporter" class="modal">
            <div class="modal__content">
                <span class="modal__close">&times;</span>
                <h2 class="modal__title">Создание отчета</h2>
                <form id="formCreateReport" class='modal__form' method="POST" action="./database/createReport.php">
                    <input class="modal__input-area" name="create_date" type="date" required placeholder="дата создания"/>
                    <input class="modal__input-area" name="box_number" type="text" required placeholder="номер коробки"/>
                    <input class="modal__input-area" name="product_count" type="number" required placeholder="количество товаров"/>
                    <input class="modal__input-area" name="time_close" type="time" required placeholder="время закрытия"/>
                    <input class="modal__input-area" name="worker" type="text" required placeholder="имя сотрудника"/>
                    <textarea class="modal__text-area" name="comment" placeholder="комментарий"></textarea>
                    <button class="modal__submit-button" type="submit">Создать отчет</button>
                </form>
            </div>
        </div>
        <div id="showReports" class="modal show-modal">
            <div class="show-modal__content">
                <span class="show-modal__close">&times;</span>
                <button class="button-hide-edit">Скрыть</button>
                <div class="edit-report">
                <div class="edit-report__title"></div>
                    <form id="editReport" class='editReport' method="POST">
                        <input class="edit-report__input-area" name="id" id="id" type="number" required hidden="true" placeholder="дата создания"/>
                        <label for="create_date">Дата создания</label>
                        <input class="edit-report__input-area" name="date_create" id="create_date" type="date" required placeholder="дата создания"/>
                        <label for="box_number">Номер коробки</label>
                        <input class="edit-report__input-area" name="box_number" id="box_number" type="text" required placeholder="номер коробки"/>
                        <label for="product_count">Количество товаров</label>
                        <input class="edit-report__input-area" name="product_count" id="product_count" type="number" required placeholder="количество товаров"/>
                        <label for="time_close">Время закрытия</label>
                        <input class="edit-report__input-area" name="time_close" id="time_close" type="time" required placeholder="время закрытия"/>
                        <label for="worker">Сотрудник</label>
                        <input class="edit-report__input-area" name="worker" id="worker" type="text" required placeholder="имя сотрудника"/>
                        <label for="comment">Комментарий</label>
                        <textarea class="edit-report__text-area" name="comment" id="comment" placeholder="комментарий"></textarea>
                        <button class="edit-report__submit-button" type="submit">Подтвердить</button>
                    </form>
                </div>
                <div class="reportsWrapper">
                    <h1 class="page-title">Список отчетов</h1>
                    <form id="formFetchReports" class='pagination__form' method="POST" action="./database/fetchReports.php">
                        <div>Выберите даты</div>
                        <div class="pagination__inputs">
                            <label for="start_date">Начало</label>
                            <input name="start_date" id="start_date" style="max-width: 200px" type="date" placeholder="Начало" required/>
                            <label for="end_date" >Конец</label>
                            <input name="end_date" id="end_date" style="max-width: 200px" type="date" placeholder="Конец" disabled/>
                        </div>
                        <button class="modal__submit-button" style="align-self: flex-start">Получить</button>
                    </form>
                    <button class="button-create-excel"> Сформировать отсчет excel</button>
                    <button class="button-delete-reports"> Удалить все</button>
                    <table class="table" id="reports-table">
                        <thead class="table__head">
                        <tr class="table__row">
                            <th class="table__header">ID</th>
                            <th class="table__header">Дата</th>
                            <th class="table__header">Номер коробки</th>
                            <th class="table__header">Количество</th>
                            <th class="table__header">Время закрытия</th>
                            <th class="table__header">Работник</th>
                            <th class="table__header">Комментарий</th>
                            <th class="table__header">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="table__body" id="reports-body">
                        </tbody>
                    </table>
                    <div class="table__marker-not-data">
                    </div>
                    <div class="pagination" id="pagination">
                    </div>
                </div>
            </div>
        </div>
        <div id="editSchedule" class="modal show-modal">

        </div>
        <script src="js/scripts.js" type="module"></script>
    </body>
</html>
