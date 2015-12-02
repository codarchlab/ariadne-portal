/**
 * A chart showing a range of years on a timeline and the number of
 * resources found which have from dates for these years.
 *
 * @param container the id of the dom element used
 *   to show the chart.
 */
function BarChart(container) {

    /**
     * Basic setup of the c3 bar chart to fit our purposes.
     */
    var chart = c3.generate({
        bindto: '#'+container,
        data: {
            x: 'Years',
            columns: [
                ['Years'],     // x axis
                ['From Dates: ']  // data
            ],
            type: 'bar',
            onclick: function(e) { console.log("TODO trigger location change for event: ",e); }
        },
        color: {
            pattern: ['#D5A03A','#FFFFFF']
        },
        legend: {
            show: false
        },
        bar: {
            width: 10
        },
        axis: {
            y: {
                show: false
            }
        }
    });

    /**
     * Expects a dateString starting with the year and
     * returns the year portion of it.
     *
     * @param dateString (-)YYYY(.*)
     * @returns {string} (-)YYYY
     */
    var getYear = function(dateString) {
        if (dateString.slice(0, 1) == "-")
            return dateString.substring(0, 5);
        else
            return dateString.substring(0,4);
    };

    /**
     * Pushes one fromDateCount for the year.
     * Searches fromDatesBuckets for counts for years.
     * If there is no count, 0 will be pushed.
     *
     * @param year {string} of format YYYY.
     * @param fromDatesCount {array} one count will be pushed to this array.
     * @param fromDatesBuckets elastic search date_histogram year buckets.
     */
    var pushFromDateCount = function(year,fromDatesCount,fromDatesBuckets) {
        var itemFound=false;
        for (var j in fromDatesBuckets) {

            if (getYear(fromDatesBuckets[j].key_as_string)==year){
                fromDatesCount.push(fromDatesBuckets[j].doc_count);
                itemFound=true;
            }
        }
        if (itemFound==false) fromDatesCount.push(0);
    };

    /**
     * Fetches, processes and inserts the
     * processed data to the bar chart diagram.
     *
     * Presents data within the range beginning with startYear and
     * ending with endYear.
     *
     * @param startYear
     * @param endYear
     */
    this.present = function(startYear,endYear) {

        $.getJSON("/search?_all", function(data) {

            var years = ['Years'];
            var fromDatesCount = ['From Dates: '];

            for (var i=startYear;i<=endYear;i++) {
                years.push(i.toString());
                pushFromDateCount(i.toString(),fromDatesCount,data.aggregations.from_dates.buckets);
            }

            chart.load({
                columns: [
                    years,
                    fromDatesCount
                ]
            });
        });
    };
}