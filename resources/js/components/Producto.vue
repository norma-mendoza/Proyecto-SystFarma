<template>
  <main class="main">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card mt-2">
        <div class="card-header">
          
            <div class="col-md-12">
              <i class="fa fa-align-justify"></i> Listado de Productos
              <el-button
              plain
            type="success"
            icon="el-icon-circle-plus"
            @click="abrirModal('producto', 'registrar')"
          >Nuevo</el-button>
          
          <el-button
            type="danger"
            icon="el-icon-document"
            @click="cargarPdf()"
          >Reporte</el-button>
            </div>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-12 col-12">
              <div class="input-group">
                <div class="mr-1">
                  <template>
                    <el-select v-model="criterio" placeholder="Select">
                      <el-option
                        v-for="item in options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                      ></el-option>
                    </el-select>
                  </template>
                </div>

                <div class="mr-1">
                  <el-input
                    @keyup.native.enter="
                                            listarProducto(1, buscar, criterio)
                                        "
                    placeholder="Texto a buscar"
                    v-model="buscar"
                  ></el-input>
                </div>

                <div>
                  <el-button
                    icon="el-icon-search"
                    type="success"
                    @click="
                                            listarProducto(1, buscar, criterio)
                                        "
                  >Buscar</el-button>
                </div>
              </div>
            </div>
          </div>
          <table class="table table-sm table-responsive">
            <thead>
              <tr>
                <th>Opciones</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>UsoTerapeutico</th>
                <th>SustanciaActiva</th>
                <th>PrecioCompra</th>
                <th>PrecioVenta</th>
                <th>FechaVencimiento</th>
                <th>Stock</th>
                <th>Ubicacion</th>
                <th>Lote</th>
                <th>Categoria</th>
                <th>Laboratorio</th>
                <th>Presentacion</th>
                <th>Proveedor</th>
                <th>Descuento</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="producto in arrayProducto" :key="producto.id">
                <td>
                  <button
                    type="button"
                    @click="
                                            abrirModal(
                                                'producto',
                                                'actualizar',
                                                producto
                                            )
                                        "
                    class="btn btn-warning btn-sm"
                  >
                    <i class="icon-pencil"></i>
                  </button>
                  &nbsp;
                  <template v-if="producto.condicion">
                    <button
                      type="button"
                      @click="
                                                desactivarProducto(producto.id)
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
                                                activarProducto(producto.id)
                                            "
                      class="btn btn-info btn-sm"
                    >
                      <i class="icon-check"></i>
                    </button>
                  </template>
                </td>
                <td v-text="producto.codigo"></td>
                <td v-text="producto.nombre"></td>
                <td v-text="producto.usoTerapeutico"></td>
                <td v-text="producto.sustanciaActiva"></td>
                <td v-text="producto.precioCompra"></td>
                <td v-text="producto.precio_venta"></td>
                <td v-text="producto.fechaVencimiento"></td>
                <td v-text="producto.stock"></td>
                <td v-text="producto.ubicacion"></td>
                <td v-text="producto.lote"></td>
                <td v-text="producto.categoria"></td>
                <td v-text="producto.laboratorio"></td>
                <td v-text="producto.presentacion"></td>
                <td v-text="producto.proveedor"></td>
                <td v-text="producto.IgvIncluido"></td>
                <td v-text="producto.descuento"></td>
                <td>
                  <div v-if="producto.condicion">
                    <span class="badge badge-success">Activo</span>
                  </div>
                  <div v-else>
                    <span class="badge badge-danger">Desactivado</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
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
                >Ant</a>
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
                >Sig</a>
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
      role="document"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-md modal-primary modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title" v-text="tituloModal"></h6>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <div v-show="errorProducto" class="form-group row div-error">
                  <div class="text-center text-error">
                    <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error"></div>
                  </div>
                </div>
              <div class="row">
                
                <div class="col-md-4">
                  <div class>
                    <label class for="text-input">Codigo barras</label>
                    <div class>
                      <el-input placeholder="codigo" size="mini" v-model="codigo"></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div>
                    <label class for="text-input">Nombre</label>
                    <div class>
                      <el-input   placeholder="Nombre Laboratorio" size="mini" v-model="nombre"></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Uso terapeutico</label>
                    <div class>
                      <el-input placeholder="Uso terapeutico" size="mini" v-model="usoTerapeutico"></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Sustancia Activa</label>
                    <div class>
                      <el-input
                        placeholder="sustancia activa"
                        size="mini"
                        v-model="sustanciaActiva"
                      ></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Precio compra</label>
                    <div class>
                      <el-input
                        placeholder="precio compra"
                        size="mini"
                        v-model="precioCompra"
                      ></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Precio venta</label>
                    <div class>
                      <el-input placeholder="precio venta" size="mini" v-model="precioVenta"></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Fecha vencimiento</label>
                    <div class>
                      <!-- <el-input placeholder="fecha vencimiento" size="mini" v-model="fechaVencimiento"></el-input> -->

                      <div class="block">
                        <el-date-picker
                          v-model="fechaVencimiento"
                          type="date"
                          placeholder="Escoge un día"
                          format="yyyy/MM/dd"
                          value-format="yyyy-MM-dd"                          
                          size="mini"
                        ></el-date-picker>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Stock</label>
                    <div class>
                      <el-input placeholder="stock" size="mini" v-model.number="stock"></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Ubicacion</label>
                    <div class>
                      <el-input placeholder="ubicacion" size="mini" v-model="ubicacion"></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Lote</label>
                    <div class>
                      <el-input placeholder="lote" size="mini" v-model.number="lote"></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">categoria</label>
                    <div class>
                      <template>
                        <el-select
                          size="mini"
                          v-model="idCategoria"
                          placeholder="Selecciona la categoria"
                        >
                          <el-option
                            v-for="categoria in arrayCategoria"
                            :key="categoria.id"
                            :label="categoria.nombre"
                            :value="categoria.id"
                          ></el-option>
                        </el-select>
                      </template>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Laboratorio</label>
                    <div class>
                      <template>
                        <el-select
                          size="mini"
                          v-model="idLaboratorio"
                          placeholder="Selecciona el Laboratorio"
                        >
                          <el-option
                            v-for="laboratorio in arrayLaboratorio"
                            :key="laboratorio.id"
                            :label="laboratorio.nombre"
                            :value="laboratorio.id"
                          ></el-option>
                        </el-select>
                      </template>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Presentacion</label>
                    <div class>
                      <template>
                        <el-select
                          size="mini"
                          v-model="idPresentacion"
                          placeholder="Selecciona la presentacion"
                        >
                          <el-option
                            v-for="presentacion in arrayPresentacion"
                            :key="presentacion.id"
                            :label="presentacion.nombre"
                            :value="presentacion.id"
                          ></el-option>
                        </el-select>
                      </template>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Proveedor</label>
                    <div class>
                      <template>
                        <el-select
                          size="mini"
                          v-model="idProveedor"
                          placeholder="Selecciona el proveedor"
                        >
                          <el-option
                            v-for="proveedor in arrayProveedor"
                            :key="proveedor.id"
                            :label="proveedor.nombre"
                            :value="proveedor.id"
                          ></el-option>
                        </el-select>
                      </template>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div>
                    <label class for="text-input">Descuento</label>
                    <div class>
                      <el-input placeholder="lote" size="mini" v-model.number="descuento"></el-input>
                    </div>
                  </div>
                </div>
                
              </div>
              <!-- fin form -->
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" @click="cerrarModal()">Cerrar</button>
            <button
              type="button"
              v-if="tipoAccion == 1"
              class="btn btn-primary"
              @click="registrarProducto()"
            >Guardar</button>
            <button
              type="button"
              v-if="tipoAccion == 2"
              class="btn btn-primary"
              @click="actualizarProducto()"
            >Actualizar</button>
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
      input: "",
      //para select
      options: [
        {
          value: "Nombre",
          label: "Nombre"
        },
        {
          value: "Codigo",
          label: "Codigo"
        }
      ],

      value: "",
      //fin select
      producto_id: 0,     
      codigo: "",
      nombre: "",
      usoTerapeutico: "",
      sustanciaActiva: "",
      precioCompra: "",
      precioVenta: "",
      fechaVencimiento: "",
      stock: "",
      ubicacion: "",
      lote: "",
      idCategoria: "",
      nombreCategoria: "",
      idLaboratorio: "",
      nombreLaboratorio: "",
      idPresentacion: "",
      nombrePresentacion: "",
      idProveedor: "",
      nombreProveedor: "",
      igvIncluido: "",
      descuento: "",
     
     rules: {
       nombre :[
          { required: true, message: 'Por favor escribe el nombre', trigger: 'blur' }
       ],
     },
      arrayProducto: [],
      arrayCategoria: [],
      arrayLaboratorio: [],
      arrayPresentacion: [],
      arrayProveedor: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorProducto: 0,
      errorMostrarMsjProducto: [],
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
    //carga pdf products
    cargarPdf(){
      window.open('/producto/listarPdf','_blank');
      },
    
    guardar() {
      this.$message({
        message: "Producto Guardado con éxito.",
        type: "success"
      });
    },
    editar() {
      this.$message({
        message: "Producto Actualizado con éxito.",
        type: "success"
      });
    },
    selectProveedor() {
      let me = this;
      var url = "/proveedor/selectProveedor";

      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayProveedor = respuesta.proveedores;
          //me.pagination = respuesta.pagination;
          // console.log(arrayCategoria);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    selectPresentacion() {
      let me = this;
      var url = "/presentacion/selectPresentacion";

      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayPresentacion = respuesta.presentaciones;
          //me.pagination = respuesta.pagination;
          // console.log(arrayCategoria);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    selectLaboratorio() {
      let me = this;
      var url = "/laboratorio/selectLaboratorio";

      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayLaboratorio = respuesta.laboratorios;
          //me.pagination = respuesta.pagination;
          // console.log(arrayCategoria);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    selectCategoria() {
      let me = this;
      var url = "/categoria/selectCategoria";

      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayCategoria = respuesta.categorias;
          //me.pagination = respuesta.pagination;
          // console.log(arrayCategoria);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    listarProducto(page, buscar, criterio) {
      let me = this;
      var url =
        "/producto?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayProducto = respuesta.productos.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      me.pagination.current_page = page;
      me.listarProducto(page, buscar, criterio);
    },
    registrarProducto() {
      
      //validando campos categoria
      if (this.validarProducto()) {
        return;
      }

      let me = this;

      axios
        .post("/producto/registrar", {
          codigo: this.codigo,
          nombre: this.nombre,
          usoTerapeutico: this.usoTerapeutico,
          sustanciaActiva: this.sustanciaActiva,
          precio_compra: this.precioCompra,
          precio_venta: this.precioVenta,
          fechaVencimiento: this.fechaVencimiento,
          stock: this.stock,
          ubicacion: this.ubicacion,
          lote: this.lote,
          idCategoria: this.idCategoria,
          idLaboratorio: this.idLaboratorio,
          idPresentacion: this.idPresentacion,
          idProveedor: this.idProveedor,
          igv_incluido: this.igvIncluido,
          descuento: this.descuento
         // id: this.producto_id
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarProducto(1, "", "nombre");
          me.guardar();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarProducto() {
      //validando campos categoria
      if (this.validarProducto()) {
        return;
      }

      let me = this;
      axios
        .put("/producto/actualizar", {
          codigo: this.codigo,
          nombre: this.nombre,
          usoTerapeutico: this.usoTerapeutico,
          sustanciaActiva: this.sustanciaActiva,
          precio_compra: this.precioCompra,
          precio_venta: this.precioVenta,
          fechaVencimiento: this.fechaVencimiento,
          stock: this.stock,
          ubicacion: this.ubicacion,
          lote: this.lote,
          idCategoria: this.idCategoria,
          idLaboratorio: this.idLaboratorio,
          idPresentacion: this.idPresentacion,
          idProveedor: this.idProveedor,
          igv_incluido: this.igvIncluido,
          descuento: this.descuento,
          id: this.producto_id
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarProducto(1, "", "nombre");
          me.editar();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    desactivarProducto(id) {
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
            .put("/producto/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listarProducto(1, "", "nombre");
            })
            .catch(function(error) {
              console.log(error);
            });
        }
      });
    },
    activarProducto(id) {
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
            .put("/producto/activar", {
              id: id
            })
            .then(function(response) {
              Swal.fire(
                "Activado!",
                "El registro ha sido desactivado con éxito.",
                "success"
              );
              me.listarProducto(1, "", "nombre");
            })
            .catch(function(error) {
              console.log(error);
            });
        }
      });
    },
    validarProducto() {
      this.errorProducto = 0;
      this.errorMostrarMsjProducto = [];

      if (!this.nombre)
        this.errorMostrarMsjProducto.push(
         
          "El nombre del producto no puede estar vacío."
        );
        else if(!this.precioCompra) 
        this.errorMostrarMsjProducto.push(
          "El precio compra del producto no puede estar vacío."
        );
        else if(!this.precioVenta)        
        this.errorMostrarMsjProducto.push(
          "El precio venta del producto no puede estar vacío."         

        );
        else if(!this.fechaVencimiento) 
        this.errorMostrarMsjProducto.push(
          "Seleccionar la fecha de vencimiento "
          
        );
        else if(!this.stock) 
        this.errorMostrarMsjProducto.push(
          "Ingresa el stock "
          
        );
         else if(!this.idCategoria) 
        this.errorMostrarMsjProducto.push(
          "Seleccionar la categoria "
        );
        else if(!this.idLaboratorio) 
        this.errorMostrarMsjProducto.push(
          "Seleccionar el laboratorio "
          
        );
        else if(!this.idPresentacion) 
        this.errorMostrarMsjProducto.push(
          "Seleccionar el presentacion "
          
        );
        else if(!this.idProveedor) 
        this.errorMostrarMsjProducto.push(
          "Seleccionar el proveedor "
          
        );

        

      if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;

      return this.errorProducto;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.nombre = "";
      this.usoTerapeutico = "";
    },
    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "producto": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar Producto";
              this.codigo = "";
              this.nombre = "";
              this.usoTerapeutico = "";
              this.sustanciaActiva = "";
              this.precioCompra = "";
              this.precioVenta = "";
              this.fechaVencimiento = "";
              this.stock = "";
              this.ubicacion = "";
              this.lote = "";
              this.idCategoria = "";
              this.idLaboratorio = "";
              this.idPresentacion = "";
              this.idProveedor = "";
              this.nombreCategoria = "";
              this.nombreLaboratorio = "";
              this.nombrePresentacion = "";
              this.nombreProveedor = "";
              this.descuento = "";
              this.tipoAccion = 1;
              break;
            }
            case "actualizar": {
              this.modal = 1;
              this.tituloModal = "Actualizar producto";
              this.tipoAccion = 2;
              this.producto_id = data["id"];
              this.codigo = data["codigo"];
              this.nombre = data["nombre"];
              this.usoTerapeutico = data["usoTerapeutico"];
              this.sustanciaActiva = data["sustanciaActiva"];
              this.precioCompra = data["precioCompra"];
              this.precioVenta = data["precio_venta"];
              this.fechaVencimiento = data["fechaVencimiento"];
              this.stock = data["stock"];
              this.ubicacion = data["ubicacion"];
              this.lote = data["lote"];
              this.idCategoria = data["idCategoria"];
              this.idLaboratorio = data["idLaboratorio"];
              this.idPresentacion = data["idpresentacion"];
              this.idProveedor = data["idProveedor"];
              this.descuento = data["descuento"];

              break;
            }
          }
        }
      }
      this.selectCategoria();
      this.selectLaboratorio();
      this.selectPresentacion();
      this.selectProveedor();
    }
  },
  mounted() {
    this.listarProducto(1, this.buscar, this.criterio);
  }
};
</script>
<style>
.modal-content {
  width: 100% !important;
  border-radius: 6px;
  margin-top: 0px;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
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
