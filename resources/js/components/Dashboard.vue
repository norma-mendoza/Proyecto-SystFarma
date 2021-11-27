<template>
    <main class="main">
        <!-- Breadcrumb -->
        <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol> -->
        <div class="container-fluid">
            <div class="card mt-10">
                <!-- <div class="card-header">
                
            </div> -->
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-3 col-12 .col-sm-12">
                            <div class="cards">
                                <div class="cards-title">
                                    <div class="titulo">
                                        <p>Venta en el dia</p>
                                    </div>
                                </div>
                                <div class="cards-body">
                                    <div class="icon">
                                        <div>
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <h4>s/. {{totalDia}}</h4>
                                        
                                    </div>
                                </div>
                                <div class="cards-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12  .col-sm-12">
                            <div class="cards">
                                <div class="cards-title1">
                                    <div class="titulo">
                                        <p>Compras en el dia</p>
                                    </div>
                                </div>
                                <div class="cards-body">
                                    <div class="icon1">
                                        <div>
                                            <i class="fas fa-shopping-basket"></i>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div><h4>s/. {{compraDia}}</h4></div>
                                    </div>
                                </div>
                                <div class="cards-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12 .col-sm-12">
                            <div class="cards">
                                <div class="cards-title2">
                                    <div class="titulo">
                                        <p>Total Compras</p>
                                    </div>
                                </div>
                                <div class="cards-body">
                                    <div class="icon2">
                                        <div>
                                            <i class="fas fa-donate"></i>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div><h4>s/. {{compraTodos}}</h4></div>
                                    </div>
                                </div>
                                <div class="cards-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12 .col-sm-12 ">
                            <div class="cards">
                                <div class="cards-title3">
                                    <div class="titulo">
                                        <p>Total Ventas</p>
                                    </div>
                                </div>
                                <div class="cards-body">
                                    <div class="icon3">
                                        <div>
                                            <i class="fas fa-money-check-alt"></i>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div><h4>s/. {{VentaTodos}}</h4></div>
                                    </div>
                                </div>
                                <div class="cards-footer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Ingresos</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="ingresos"> </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Compras de los últimos meses.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Ventas</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="ventas"> </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Ventas de los últimos meses.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import Chart from "chart.js";
export default {
    data() {
        return {
            ventasporDia: [],
           totalDias:null,
            //
            comprasporDia:[],
            totalesComprasTodo:null,
            //
            arrayComprasTodos:[],
            totalesComprasTodo:null,
            //
            arrayventasTodos:[],
            totalesVentasTodo:null,
            //
            varIngreso: null,
            charIngreso: null,
            ingresos: [],
            varTotalIngreso: [],
            varMesIngreso: [],

            varVenta: null,
            charVenta: null,
            ventas: [],
            varTotalVenta: [],
            varMesVenta: []
            
        };
    },
    methods: {
        getIngresos() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.ingresos = respuesta.ingresos;
                    //console.log(respuesta.ventaDia);
                    //cargamos los datos del chart
                    me.loadIngresos();
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getVentaDia() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.ventasporDia = respuesta.ventaDia;
                   
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getCompraDia() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.comprasporDia = respuesta.ingresoDia;
                   
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getCompraTodos() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayComprasTodos = respuesta.TotalCompras;
                   
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getVentasTodos() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayventasTodos = respuesta.TotalVentas;
                   
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getVentas() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.ventas = respuesta.ventas;
                    //cargamos los datos del chart
                    me.loadVentas();
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        loadIngresos() {
            let me = this;
            me.ingresos.map(function(x) {
                me.varMesIngreso.push(x.mes);
                me.varTotalIngreso.push(x.total);
            });
            me.varIngreso = document
                .getElementById("ingresos")
                .getContext("2d");

            me.charIngreso = new Chart(me.varIngreso, {
                type: "line",
                data: {
                    labels: me.varMesIngreso,
                    datasets: [
                        {
                            label: "Ingresos",
                            data: me.varTotalIngreso,
                            backgroundColor: "rgba(249, 255, 250, 0.2)",
                            borderColor: "rgba(28, 227, 37)",
                            borderWidth: 3
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            });
        },
        loadVentas() {
            let me = this;
            me.ventas.map(function(x) {
                me.varMesVenta.push(x.mes);
                me.varTotalVenta.push(x.total);
            });
            me.varVenta = document.getElementById("ventas").getContext("2d");

            me.charVenta = new Chart(me.varVenta, {
                type: "line",
                data: {
                    labels: me.varMesVenta,
                    datasets: [
                        {
                            label: "Ventas",
                            data: me.varTotalVenta,
                            backgroundColor: "rgba(249, 255, 250, 0.2)",
                            borderColor: "rgba(253, 96, 172 )",
                            borderWidth: 3
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            });
        }
        
    },
    mounted() {
        
        this.getIngresos();
        this.getVentas();
        this.getVentaDia();
        this.getCompraDia();
        this.getCompraTodos();
        this.getVentasTodos();
       //this.totalizarVentadia();
       

    },
    
    computed:{
            totalDia(){
                this.totalDias = 0;
                
                for(let item of this.ventasporDia){
                    this.totalDias = this.totalDias + parseFloat(item.total);
                }
                return (this.totalDias.toFixed(2));   
            },

            compraDia(){
                this.totalcomprashoy = 0;
                
                for(let item of this.comprasporDia){
                    this.totalcomprashoy = this.totalcomprashoy + parseFloat(item.total);
                }
                return (this.totalcomprashoy.toFixed(2));   
            },
            compraTodos(){
                this.totalesComprasTodo = 0;
                
                for(let item of this.arrayComprasTodos){
                    this.totalesComprasTodo = this.totalesComprasTodo + parseFloat(item.total);
                }
                return (this.totalesComprasTodo.toFixed(2));   
            },
            VentaTodos(){
                this.totalesVentasTodo = 0;
                
                for(let item of this.arrayventasTodos){
                    this.totalesVentasTodo = this.totalesVentasTodo + parseFloat(item.total);
                }
                return (this.totalesVentasTodo.toFixed(2));   
            }
} 
};
</script>
