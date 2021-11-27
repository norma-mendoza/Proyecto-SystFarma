<template>
    <main class="main">
        <!-- Breadcrumb -->
        <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Escritoriosdsdd</a>
            </li>
        </ol> -->
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card mt-2">
                <div class="card-header">
                    
                    <i class="fa fa-align-justify"></i> Laboratorios
                   
                    <el-button plain type="success" icon="el-icon-circle-plus"  @click="abrirModal('laboratorio', 'registrar')">Nuevo</el-button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12 col-12">
                            <div class="input-group">
                                
                                <div class="mr-1 ">
                                    <template>
                                    <el-select v-model="criterio" placeholder="Select">
                                        <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                                    </template>
                                </div>                                                    


                                <div class="mr-1  ">
                                   <el-input @keyup.native.enter="
                                        listarLaboratorio(1, buscar, criterio)
                                    " placeholder="Texto a buscar" v-model="buscar"></el-input>

                                </div>
                                
                                <div>
                                      <el-button icon="el-icon-search" type="success" @click="
                                        listarLaboratorio(1, buscar, criterio)
                                    " >Buscar</el-button>
                                </div>    
                                
                            </div>
                        </div>
                    </div>
                    <table class="table table-sm table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="laboratorio in arrayLaboratorio"
                                :key="laboratorio.id"
                            >
                                <td>
                                    <button
                                        type="button"
                                        @click="
                                            abrirModal(
                                                'laboratorio',
                                                'actualizar',
                                                laboratorio
                                            )
                                        "
                                        class="btn btn-warning btn-sm"
                                    >
                                        <i class="icon-pencil"></i>
                                    </button>
                                    &nbsp;
                                    <template v-if="laboratorio.condicion">
                                        <button
                                            type="button"
                                            @click="
                                                desactivarLaboratorio(
                                                    laboratorio.id
                                                )
                                            "
                                            class="btn btn-danger btn-sm"
                                        >
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button
                                            type="button"
                                            @click="
                                                activarLaboratorio(laboratorio.id)
                                            "
                                            class="btn btn-info btn-sm"
                                        >
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="laboratorio.nombre"></td>
                                <td v-text="laboratorio.descripcion"></td>
                                <td>
                                    <div v-if="laboratorio.condicion">
                                        <span class="badge badge-success"
                                            >Activo</span
                                        >
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger"
                                            >Desactivado</span
                                        >
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li
                                class="page-item"
                                v-if="pagination.current_page > 1"
                            >
                                <a
                                    class="page-link"
                                    href="#"
                                    @click.prevent="
                                        cambiarPagina(
                                            pagination.current_page - 1,
                                            buscar,
                                            criterio
                                        )
                                    "
                                    >Ant</a
                                >
                            </li>
                            <li
                                class="page-item"
                                v-for="page in pagesNumber"
                                :key="page"
                                :class="[page == isActived ? 'active' : '']"
                            >
                                <a
                                    class="page-link"
                                    href="#"
                                    @click.prevent="
                                        cambiarPagina(page, buscar, criterio)
                                    "
                                    v-text="page"
                                ></a>
                            </li>

                            <li
                                class="page-item"
                                v-if="
                                    pagination.current_page <
                                        pagination.last_page
                                "
                            >
                                <a
                                    class="page-link"
                                    href="#"
                                    @click.prevent="
                                        cambiarPagina(
                                            pagination.current_page + 1,
                                            buscar,
                                            criterio
                                        )
                                    "
                                    >Sig</a
                                >
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div
            class="modal fade"
            tabindex="-1"
            :class="{ mostrar: modal }"
            role="dialog"
            aria-labelledby="myModalLabel"
            style="display: none;"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-primary modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button
                            type="button"
                            class="close"
                            @click="cerrarModal()"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form
                            action
                            method="post"
                            enctype="multipart/form-data"
                            class="form-horizontal"
                        >
                            <div class="form-group row">
                                <label
                                    class="col-md-3 text-center form-control-label"
                                    for="text-input"
                                    >Nombre</label
                                >
                                <div class="col-md-9">
                                    <el-input placeholder="Nombre Laboratorio" v-model="nombre"></el-input>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-3 text-center form-control-label"
                                    for="email-input"
                                    >Descripción</label
                                >
                                <div class="col-md-9">
                                    <el-input placeholder="Ingrese descripción" v-model="descripcion"></el-input>

                                    
                                </div>
                            </div>
                            <div
                                v-show="errorLaboratorio"
                                class="form-group row div-error"
                            >
                                <div class="text-center text-error">
                                    <div
                                        v-for="error in errorMostrarMsjLaboratorio"
                                        :key="error"
                                        v-text="error"
                                    ></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-danger"
                            @click="cerrarModal()"
                        >
                            Cerrar
                        </button>
                        <button
                            type="button"
                            v-if="tipoAccion == 1"
                            class="btn btn-primary"
                            @click="registrarLaboratorio()"
                        >
                            Guardar
                        </button>
                        <button
                            type="button"
                            v-if="tipoAccion == 2"
                            class="btn btn-primary"
                            @click="actualizarLaboratorio()"
                        >
                            Actualizar
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </main>
</template>

<script>
export default {
    data() {
        return {
            input: '',
            //para select
            options: [{
          value: 'Nombre',
          label: 'Nombre'
        }, {
          value: 'Descripcion',
          label: 'Descripcion'
        }],
        value: '',
            //fin select
            laboratorio_id: 0,
            nombre: "",
            descripcion: "",
            arrayLaboratorio: [],
            modal: 0,
            tituloModal: "",
            tipoAccion: 0,
            errorLaboratorio: 0,
            errorMostrarMsjLaboratorio: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0
            },
            offset: 3,
            criterio: "nombre",
            buscar: ""
        };
    },
    computed: {
        isActived: function() {
            return this.pagination.current_page;
        },
        pagesNumber: function() {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + this.offset * 2;
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    methods: {
        guardar() {
        this.$message({
          message: 'Categoria Guardado con éxito.',
          type: 'success'
        })
        },
        editar() {
        this.$message({
          message: 'Categoria Actualizado con éxito.',
          type: 'success'
        })
        },
        listarLaboratorio(page, buscar, criterio) {
            let me = this;
            var url =
                "/laboratorio?page=" +
                page +
                "&buscar=" +
                buscar +
                "&criterio=" +
                criterio;
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayLaboratorio = respuesta.laboratorios.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            me.pagination.current_page = page;
            me.listarLaboratorio(page, buscar, criterio);
        },
        registrarLaboratorio() {
            //validando campos categoria
            if (this.validarLaboratorio()) {
                return;
            }

            let me = this;

            axios
                .post("/laboratorio/registrar", {
                    nombre: this.nombre,
                    descripcion: this.descripcion
                })
                .then(function(response) {
                    me.cerrarModal();
                    me.listarLaboratorio(1, "", "nombre");
                    me.guardar();
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        actualizarLaboratorio() {
            //validando campos categoria
            if (this.validarLaboratorio()) {
                return;
            }

            let me = this;
            axios
                .put("/laboratorio/actualizar", {
                    nombre: this.nombre,
                    descripcion: this.descripcion,
                    id: this.laboratorio_id
                })
                .then(function(response) {
                    me.cerrarModal();
                    me.listarLaboratorio(1, "", "nombre");
                    me.editar();
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        desactivarLaboratorio(id) {
            Swal.fire({
                title: "Estas seguro de desactivar esta categoria?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
            }).then(result => {
                if (result.value) {
                    let me = this;
                    axios
                        .put("/laboratorio/desactivar", {
                            id: id
                        })
                        .then(function(response) {
                            me.listarLaboratorio(1, "", "nombre");
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            });
        },
        activarLaboratorio(id) {
            Swal.fire({
                title: "Estas seguro de activar esta categoria?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
            }).then(result => {
                if (result.value) {
                    let me = this;
                    axios
                        .put("/laboratorio/activar", {
                            id: id
                        })
                        .then(function(response) {
                            Swal.fire(
                                "Activado!",
                                "El registro ha sido desactivado con éxito.",
                                "success"
                            );
                            me.listarLaboratorio(1, "", "nombre");
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            });
        },
        validarLaboratorio() {
            this.errorLaboratorio = 0;
            this.errorMostrarMsjLaboratorio = [];

            if (!this.nombre)
                this.errorMostrarMsjLaboratorio.push(
                    "El nombre de la categoría no puede estar vacío."
                );

            if (this.errorMostrarMsjLaboratorio.length) this.errorLaboratorio = 1;

            return this.errorLaboratorio;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
            this.nombre = "";
            this.descripcion = "";
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "laboratorio": {
                    switch (accion) {
                        case "registrar": {
                            this.modal = 1;
                            this.tituloModal = "Registrar Laboratorio";
                            this.nombre = "";
                            this.descripcion = "";
                            this.tipoAccion = 1;
                            break;
                        }
                        case "actualizar": {
                            this.modal = 1;
                            this.tituloModal = "Actualizar Laboratorio";
                            this.tipoAccion = 2;
                            this.laboratorio_id = data["id"];
                            this.nombre = data["nombre"];
                            this.descripcion = data["descripcion"];

                            break;
                        }
                    }
                }
            }
        }
    },
    mounted() {
        this.listarLaboratorio(1, this.buscar, this.criterio);
    }
};
</script>
<style>
.modal-content {
    width: 100% !important;
    border-radius: 6px;
     margin-top: 30px;
    position: absolute !important;
    
}
.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
   ;
}
.div-error {
    display: flex;
    justify-content: center;
}
.text-error {
    color: red !important;
    font-weight: bold;
}
</style>
