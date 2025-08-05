<?php if (isset($page_title)) : ?>
    <div class="page-title">
        <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home') ?></a></li>
                <li class="active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
            </ol>
        </div>
    </div>


<?php endif; ?>
<style>
    /*.remote-outs-loading {*/
    /*    display: none;*/
    /*    align-items: center;*/
    /*    justify-content: center;*/
    /*    height: 100%;*/
    /*    padding: 30px;*/
    /*    width: 100%;*/
    /*    background: rgba(0, 0, 0, 0.5);*/
    /*    text-align: center;*/
    /*    color: #fff;*/
    /*}*/
</style>


<div id="main-wrapper">

    <div class="row">
        <?php foreach ($trace_types_data as $trace_type) { ?>
            <div class="col-lg-4 col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter"><?= $trace_type['total'] ?></p>
                            <span class="info-box-title"><?=$this->Dictionary->GetKeyword($trace_type['name'])  ?></span>
                        </div>
                        <div class="info-box-icon">
                            <i class="<?= $trace_type['icon'] ?>"></i>
                        </div>
                        <!--                        <div class="info-box-progress">-->
                        <!--                            <div class="progress progress-xs progress-squared bs-n">-->
                        <!--                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
        <?php } ?>
    </div><!-- Row -->

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Readness Status');?></h3>
                </div>
                <div class="panel-body">
                    <div id="read_unread_char" class="text-center"></div>
                </div>
            </div>
        </div>


        <!--            <div class="col-md-6">-->
        <!--                <div class="panel panel-white">-->
        <!--                    <div class="panel-heading">-->
        <!--                        <h3 class="panel-title"> --><?php //= $this->Dictionary->GetKeyword('Remote Outs');?><!--</h3>-->
        <!--                    </div>-->
        <!--                    <div class="panel-body">-->
        <!--                        <div class="text-center p-5 remote-outs-loading">-->
        <!--                            <div class="overlay-icon">-->
        <!--                                <i class="fa fa-spinner fa-spin"></i>-->
        <!--                            </div>-->
        <!--                            <p class="mt-2">Getting Data...</p>-->
        <!--                        </div>-->
        <!--                        <div id="came_from_out_char" ></div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->



    </div>
</div>
</div>


<script>

    // var options = {
    //     series: [44, 55],
    //     chart: {
    //         width: 380,
    //         type: 'pie',
    //     },
    //     labels: ['Read', 'Unread'],
    //     colors: ['#1E90FF', '#FF6347'], // Specify colors for the slices
    //     responsive: [{
    //         breakpoint: 480,
    //         options: {
    //             chart: {
    //                 width: 200
    //             },
    //             legend: {
    //                 position: 'bottom'
    //             }
    //         }
    //     }]
    // };
    //
    // var chart = new ApexCharts(document.querySelector("#read_unread_char"), options);
    // chart.render();

    var options = {
        series: [<?= $all_read_unread['read'] ?>, <?= $all_read_unread['unread'] ?>],
        chart: {
            height: 350,
            width: 580,
            type: 'donut',
        },
        labels: ['Read', 'Unread'],
        colors: ['#1E90FF', '#FF6347'],
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function (w) {
                                // Calculate the total of the series
                                return  '<?= $all_read_unread['total'] ?>';
                            }
                        }
                    }
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#read_unread_char"), options);
    chart.render();


    $(document).ready(function () {

        //$('.remote-outs-loading').css('display', 'flex'); // Show the overlay
        //$.ajax({
        //    url: '<?php //= base_url('Admin/AjaxGetRemotesData'); ?>//',
        //    type: 'POST',
        //
        //    dataType: 'json',
        //    success: function (response) {
        //        console.log('success', response);
        //        $('.remote-outs-loading').hide();
        //        var categories = Object.keys(response).map(function(name) {
        //            return ['' + name + ''];
        //        });
        //
        //        var seriesData = Object.values(response).map(function(value) {
        //            return parseInt(value); // Convert string to integer
        //        });
        //
        //
        //        var optionsBar = {
        //            series: [{
        //                data: seriesData
        //            }],
        //            chart: {
        //                height: 350,
        //                type: 'bar',
        //                events: {
        //                    click: function(chart, w, e) {
        //                        // console.log(chart, w, e)
        //                    }
        //                }
        //            },
        //            plotOptions: {
        //                bar: {
        //                    columnWidth: '45%',
        //                    distributed: true,
        //                }
        //            },
        //            dataLabels: {
        //                enabled: false
        //            },
        //            legend: {
        //                show: false
        //            },
        //            xaxis: {
        //                categories: categories,
        //                labels: {
        //                    style: {
        //                        fontSize: '12px'
        //                    }
        //                }
        //            }
        //        };
        //
        //        var chartBar = new ApexCharts(document.querySelector("#came_from_out_char"), optionsBar);
        //        chartBar.render();
        //
        //    },
        //    error: function () {
        //        $('.remote-outs-loading').hide();
        //        console.log('error');
        //        // alert('An error occurred while checking the out book.');
        //    }
        //});


        //const controller = new AbortController(); // To cancel the fetch if needed
        //const signal = controller.signal;
        //
        //$('.remote-outs-loading').css('display', 'flex'); // Show loading
        //
        //fetch('<?php //= base_url('Admin/AjaxGetRemotesData'); ?>//', {
        //    method: 'POST',
        //    signal: signal,
        //    headers: {
        //        'Content-Type': 'application/x-www-form-urlencoded'
        //    }
        //})
        //    .then(response => response.json())
        //    .then(data => {
        //        $('.remote-outs-loading').hide();
        //
        //        // If the user already left the page, skip rendering
        //        const chartEl = document.querySelector("#came_from_out_char");
        //        if (!chartEl) return;
        //
        //        const categories = Object.keys(data).map(name => [name]);
        //        const seriesData = Object.values(data).map(value => parseInt(value));
        //
        //        const optionsBar = {
        //            series: [{ data: seriesData }],
        //            chart: {
        //                height: 350,
        //                type: 'bar',
        //            },
        //            plotOptions: {
        //                bar: {
        //                    columnWidth: '45%',
        //                    distributed: true,
        //                }
        //            },
        //            dataLabels: { enabled: false },
        //            legend: { show: false },
        //            xaxis: {
        //                categories: categories,
        //                labels: { style: { fontSize: '12px' } }
        //            }
        //        };
        //
        //        new ApexCharts(chartEl, optionsBar).render();
        //    })
        //    .catch(error => {
        //        $('.remote-outs-loading').hide();
        //
        //        if (error.name === 'AbortError') {
        //            console.log('⛔ Request was aborted by navigation');
        //        } else {
        //            console.error('❌ Fetch error:', error);
        //        }
        //    });
        //
        //// Abort the request if user navigates away
        //window.addEventListener('beforeunload', () => {
        //    controller.abort();
        //});




    });




</script>
