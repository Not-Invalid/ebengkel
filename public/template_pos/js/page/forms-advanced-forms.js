"use strict";

$(".daterange-cus").daterangepicker({
    locale: { format: "YYYY-MM-DD" },
    drops: "down",
    opens: "right",
});
$(".daterange-btn").daterangepicker(
    {
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [
                moment().subtract(1, "days"),
                moment().subtract(1, "days"),
            ],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [
                moment().subtract(1, "month").startOf("month"),
                moment().subtract(1, "month").endOf("month"),
            ],
            "Last Year": [
                moment().subtract(1, "year").startOf("year"),
                moment().subtract(1, "year").endOf("year"),
            ],
        },
        startDate: moment().subtract(29, "days"),
        endDate: moment(),
    },
    function (start, end) {
        $(".daterange-btn span").html(
            start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
        );
    }
);
