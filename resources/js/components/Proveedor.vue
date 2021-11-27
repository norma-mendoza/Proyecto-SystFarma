<template>
	<main class="main">
		<!-- Breadcrumb -->
		<!-- <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol> -->
		<div class="container-fluid">
			<!-- Ejemplo de tabla Listado -->
			<div class="card mt-2">
				<div class="card-header">
					<i class="fa fa-align-justify"></i> Listado de Proveedores
					<el-button
						plain
						type="success"
						icon="el-icon-circle-plus"
						@click="abrirModal('proveedor', 'registrar')"
						>Nuevo</el-button
					>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col-md-6">
							<div class="input-group">
								<div class="mr-1">
									<el-select
										v-model="criterio"
										placeholder="Select"
									>
										<el-option
											v-for="item in valores"
											:key="item.value"
											:label="item.label"
											:value="item.value"
										>
										</el-option>
									</el-select>
								</div>
								<div class="mr-1">
									<el-input
										@keyup.native.enter="
											listarProveedor(1, buscar, criterio)
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
											listarProveedor(1, buscar, criterio)
										"
										>Buscar</el-button
									>
								</div>
							</div>
						</div>
					</div>
					<table
						class="table table-sm table-hover table-responsive-sm"
					>
						<thead>
							<tr>
								<th>Opciones</th>
								<th>Nombre</th>
								<th>Tipo Documento</th>
								<th>Número</th>
								<th>Direción</th>
								<th>Teléfono</th>
								<th>Email</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="proveedor in arrayProveedor"
								:key="proveedor.id"
							>
								<td>
									<button
										type="button"
										@click="
											abrirModal(
												'proveedor',
												'actualizar',
												proveedor
											)
										"
										class="btn btn-warning btn-sm"
									>
										<i class="icon-pencil"></i>
									</button>
									&nbsp;
									<template v-if="proveedor.condicion">
										<button
											type="button"
											@click="
												desactivarProveedor(
													proveedor.id
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
												activarProveedor(proveedor.id)
											"
											class="btn btn-info btn-sm"
										>
											<i class="icon-check"></i>
										</button>
									</template>
								</td>
								<td v-text="proveedor.nombre"></td>
								<td v-text="proveedor.tipo_documento"></td>
								<td v-text="proveedor.num_documento"></td>
								<td v-text="proveedor.direccion"></td>
								<td v-text="proveedor.telefono"></td>
								<td v-text="proveedor.email"></td>
								<td>
									<div v-if="proveedor.condicion">
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
			style="display: none"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-primary modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" v-text="tituloModal"></h6>
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
							action=""
							method="post"
							enctype="multipart/form-data"
							class="form-horizontal"
						>
							<div class="form-group row">
								<label
									class="col-md-3 form-control-label"
									for="text-input"
									>Nombre</label
								>
								<div class="col-md-9">
									<el-input
										placeholder="Nombre del proveedor"
										v-model="nombre"
									></el-input>
								</div>
							</div>
							<div class="form-group row">
								<label
									class="col-md-3 form-control-label"
									for="text-input"
									>Tipo documento</label
								>
								<div class="col-md-9">
									<el-select
										v-model="tipo_documento"
										placeholder="Select"
									>
										<el-option
											v-for="item in options"
											:key="item.value"
											:label="item.label"
											:value="item.value"
										>
										</el-option>
									</el-select>
								</div>
							</div>
							<div class="form-group row">
								<label
									class="col-md-3 form-control-label"
									for="text-input"
									>Numero</label
								>
								<div class="col-md-9">
									<el-input
										placeholder="Numero de documento"
										v-model="num_documento"
									></el-input>
									<!-- <input class="form-control" type="text" v-model="num_documento" placeholder="Numero de documento" > -->
								</div>
							</div>
							<div class="form-group row">
								<label
									class="col-md-3 form-control-label"
									for="text-input"
									>Direccion</label
								>
								<div class="col-md-9">
									<el-input
										placeholder="Dirección"
										v-model="direccion"
									></el-input>
								</div>
							</div>
							<div class="form-group row">
								<label
									class="col-md-3 form-control-label"
									for="text-input"
									>Telefono</label
								>
								<div class="col-md-9">
									<el-input
										placeholder="Telefono"
										v-model="telefono"
									></el-input>
								</div>
							</div>
							<div class="form-group row">
								<label
									class="col-md-3 form-control-label"
									for="text-input"
									>Email</label
								>
								<div class="col-md-9">
									<el-input
										placeholder="Email@gmail.com"
										v-model="email"
									></el-input>
								</div>
							</div>

							<div
								v-show="errorProveedor"
								class="form-group row div-error"
							>
								<div class="text-center text-error">
									<div
										v-for="error in errorMostrarMsjProveedor"
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
							@click="registrarProveedor()"
						>
							Guardar
						</button>
						<button
							type="button"
							v-if="tipoAccion == 2"
							class="btn btn-primary"
							@click="actualizarProveedor()"
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
			input: "",
			//para select
			options: [
				{
					value: "DUI",
					label: "DUI",
				},
				{
					value: "NIT",
					label: "NIT",
				},
				{
					value: "PASS",
					label: "PASS",
				},
			],
			valores: [
				{
					value: "nombre",
					label: "Nombre",
				},
				{
					value: "num_documento",
					label: "Documento",
				},
				{
					value: "Email",
					label: "Email",
				},
				{
					value: "telefono",
					label: "Telefono",
				},
			],
			proveedor_id: 0,
			nombre: "",
			tipo_documento: "DUI",
			num_documento: "",
			direccion: "",
			telefono: "",
			email: "",
			arrayProveedor: [],
			modal: 0,
			tituloModal: "",
			tipoAccion: 0,
			errorProveedor: 0,
			errorMostrarMsjProveedor: [],
			pagination: {
				total: 0,
				current_page: 0,
				per_page: 0,
				last_page: 0,
				from: 0,
				to: 0,
			},
			offset: 3,
			criterio: "nombre",
			buscar: "",
		};
	},
	computed: {
		isActived: function () {
			return this.pagination.current_page;
		},
		pagesNumber: function () {
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
		},
	},
	methods: {
		guardar() {
			this.$message({
				message: "Categoria Guardado con éxito.",
				type: "success",
			});
		},
		editar() {
			this.$message({
				message: "Categoria Actualizado con éxito.",
				type: "success",
			});
		},
		listarProveedor(page, buscar, criterio) {
			let me = this;
			var url =
				"/proveedor?page=" +
				page +
				"&buscar=" +
				buscar +
				"&criterio=" +
				criterio;
			axios
				.get(url)
				.then(function (response) {
					var respuesta = response.data;
					me.arrayProveedor = respuesta.proveedores.data;
					me.pagination = respuesta.pagination;
				})
				.catch(function (error) {
					console.log(error);
				});
		},
		cambiarPagina(page, buscar, criterio) {
			let me = this;
			me.pagination.current_page = page;
			me.listarProveedor(page, buscar, criterio);
		},
		registrarProveedor() {
			//validando campos categoria
			if (this.validarProveedor()) {
				return;
			}

			let me = this;

			axios
				.post("/proveedor/registrar", {
					nombre: this.nombre,
					tipo_documento: this.tipo_documento,
					num_documento: this.num_documento,
					direccion: this.direccion,
					telefono: this.telefono,
					email: this.email,
				})
				.then(function (response) {
					me.cerrarModal();
					me.listarProveedor(1, "", "nombre");
					me.guardar();
				})
				.catch(function (error) {
					console.log(error);
				});
		},
		actualizarProveedor() {
			//validando campos categoria
			if (this.validarProveedor()) {
				return;
			}

			let me = this;
			axios
				.put("/proveedor/actualizar", {
					nombre: this.nombre,
					tipo_documento: this.tipo_documento,
					num_documento: this.num_documento,
					direccion: this.direccion,
					telefono: this.telefono,
					email: this.email,
					id: this.proveedor_id,
				})
				.then(function (response) {
					me.cerrarModal();
					me.listarProveedor(1, "", "nombre");
					me.editar();
				})
				.catch(function (error) {
					console.log(error);
				});
		},
		desactivarProveedor(id) {
			Swal.fire({
				title: "Estas seguro de desactivar este proveedor?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Aceptar",
			}).then((result) => {
				if (result.value) {
					let me = this;
					axios
						.put("/proveedor/desactivar", {
							id: id,
						})
						.then(function (response) {
							me.listarProveedor(1, "", "nombre");
						})
						.catch(function (error) {
							console.log(error);
						});
				}
			});
		},
		activarProveedor(id) {
			Swal.fire({
				title: "Estas seguro de activar este proveedor?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Aceptar",
			}).then((result) => {
				if (result.value) {
					let me = this;
					axios
						.put("/proveedor/activar", {
							id: id,
						})
						.then(function (response) {
							Swal.fire(
								"Activado!",
								"El registro ha sido desactivado con éxito.",
								"success"
							);
							me.listarProveedor(1, "", "nombre");
						})
						.catch(function (error) {
							console.log(error);
						});
				}
			});
		},

		validarProveedor() {
			this.errorProveedor = 0;
			this.errorMostrarMsjProveedor = [];

			if (!this.nombre)
				this.errorMostrarMsjProveedor.push(
					"El nombre de la proveedor no puede estar vacío."
				);

			if (this.errorMostrarMsjProveedor.length) this.errorProveedor = 1;

			return this.errorProveedor;
		},
		cerrarModal() {
			this.modal = 0;
			this.tituloModal = "";
			this.nombre = "";
			this.tipo_documento = "";
			this.num_documento = "";
			this.direccion = "";
			this.telefono = "";
			this.email = "";
			this.errorProveedor = 0;
		},
		abrirModal(modelo, accion, data = []) {
			switch (modelo) {
				case "proveedor": {
					switch (accion) {
						case "registrar": {
							this.modal = 1;
							this.tituloModal = "Registrar Proveedor";
							this.nombre = "";
							this.tipo_documento = "NIT";
							this.num_documento = "";
							this.direccion = "";
							this.telefono = "";
							this.email = "";
							this.tipoAccion = 1;
							break;
						}
						case "actualizar": {
							this.modal = 1;
							this.tituloModal = "Actualizar proveedor";
							this.tipoAccion = 2;
							this.proveedor_id = data["id"];
							this.nombre = data["nombre"];
							this.tipo_documento = data["tipo_documento"];
							this.num_documento = data["num_documento"];
							this.direccion = data["direccion"];
							this.telefono = data["telefono"];
							this.email = data["email"];

							break;
						}
					}
				}
			}
		},
	},
	mounted() {
		this.listarProveedor(1, this.buscar, this.criterio);
	},
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
