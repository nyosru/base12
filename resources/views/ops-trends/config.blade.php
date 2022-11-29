    [
            @foreach($tchart->getDatasets() as $dataset_el)
        {
            type: "line",
            data: {
                labels: periods,
                datasets: {!! json_encode(array_values($dataset_el)) !!}
        },
            options: {
                showTooltips: false,
                onClick: function(evt,item){
                    {{--var obj=this.chart.getElementsAtEventForMode(evt, 'index', { intersect: false })[0];--}}
                    {{--var obj=this.chart.getElementsAtEvent(evt);--}}
                    if(item.length){
                        var obj=item[0];
                        showChartPeriodDetails(obj._chart.config.data["datasets"][obj._datasetIndex].trends_chart_id,
                                            obj._chart.config.data.labels[obj._index]);
                    }
                },
                plugins: {
                    datalabels: {
                        color: 'white',
                        labels: {
                            title: {
                                font: {
                                    weight: 'bold'
                                }
                            },
                            value: {
                                color: 'white'
                            }
                        }
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: ""
                },
                tooltips: {
                    mode: "index",
                    intersect: false,
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: "Period"
                        },
                        gridLines: {
                            display:false
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: "Value"
                        },
                        gridLines: {
                            display:false
                        },
                        ticks: {
                            min: {{floor(0.5*\App\classes\trends\DatasetMinMax::min(array_values($dataset_el)))}},
                            max: {{round(1.5*\App\classes\trends\DatasetMinMax::max(array_values($dataset_el)))}}
                        }
                    }]
                }
            }
        }{{($loop->index<($loop->count-1)?",":"")}}
        @endforeach
    ]