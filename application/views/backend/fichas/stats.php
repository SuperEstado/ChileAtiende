<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$cnt = 1;
$data = '';
foreach ($stats as $stat) {
    $coma = ',';
    if ($cnt >= count($stats))
        $coma = '';
    $data .= $stat->count . $coma;
    $cnt++;
}
?>
<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/' . ( ($flujo) ? 'fichas/listarflujos' : 'fichas' )) ?>"><?= ($flujo) ? 'Flujos' : 'Fichas' ?></a> »
    <span>Stats <?= ($flujo) ? 'Flujo' : 'Ficha' ?> #<?= $ficha->id ?></span>
</div>

<div class="pane">
    
    <?php $this->load->view('backend/fichas/menu', array('tab' => 'stats', 'flujo' => $flujo)) ?>
    
    <h2><?php echo $ficha->titulo ?></h2>
    
    <script type="text/javascript">
        $(function () {
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        type: 'area'
                    },
                    title: {
                        text: 'Estadísticas de visualización'
                    },
                
                    xAxis: {
                        type: 'datetime'
                    
                    },
                    yAxis: {
                        title: {
                            text: 'Visitas'
                        },
                        labels: {
                            formatter: function() {
                                return this.value / 1 +'k';
                            }
                        }
                    },
                    tooltip: {
                        xDateFormat: '%Y-%m-%d',
                        formatter: function() {
                            return this.series.name +' vista <b>'+ Highcharts.numberFormat(this.y, 0) +'</b>veces ';
                        }
                    },
                    plotOptions: {
                        area: {
                            marker: {
                                enabled: false,
                                symbol: 'circle',
                                radius: 2,
                                states: {
                                    hover: {
                                        enabled: true
                                    }
                                }
                            }
                        }
                    },
                    exporting: {
                        buttons: {
                            exportButton: {
                                enabled: true
                            }
                        },
                        enabled: true,
                        filename : '<?php echo str_replace(' ', '_', strtolower($ficha->titulo) ) ?>',
                        type: 'image/png',
                        url: 'http://export.highcharts.com'
                    },
                    series: [{
                            pointInterval: 1 * 24 * 3600000,
                            pointStart: Date.UTC(<?php echo str_replace('-',',',$fecha->mindate) ?>),
                            name: 'Ficha',
                            data: [ <?php echo $data ?> ]
                        }]
                });
            });
    
        });
    </script>
    <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
    <script src="<?php echo site_url('/assets/js/highcharts/highcharts.js') ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('/assets/js/highcharts/modules/exporting.js') ?>"></script>

</div>