import modalReporter from './modalReporter.js';
import paginationReports from "./paginationReports.js";
import closeModalIsOpen from "./closeModalIsOpen.js"
import createReportExcel from  "./createReportExcel.js";

$(document).ready(function() {
    modalReporter();
    paginationReports();
    closeModalIsOpen();
    createReportExcel();
});
