function createReportExcel() {
    $('.button-create-excel').on('click', function (){
        const reportsBody = $('.table__body');

        let start_date = reportsBody.data('start_date');
        let end_date = reportsBody.data('end_date');

        const url = new URL('http://lorean.local/database/createExcel.php')
        url.searchParams.append('start_date', start_date)
        if (end_date) {
            url.searchParams.append('end_date', end_date)
        }
        fetch(url, {
            method: "GET",
            headers: {
                'Content-Type': 'application/json',
                'charset': 'utf8'
            }
        })
            .then(response => {
                if (response.ok){
                    console.log(response.json())
                }else {
                    alert('Ошибка получения данных')
                }
            }).then(data => {
                console.log(data)
        })
    })
}

export default createReportExcel;