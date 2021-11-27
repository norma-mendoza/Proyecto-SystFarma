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
					<i class="fa fa-align-justify"></i> Empleados
					<el-button
						plain
						type="success"
						icon="el-icon-circle-plus"
						@click="abrirModal('empleado', 'registrar')"
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
											listarEmpleado(1, buscar, criterio)
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
											listarEmpleado(1, buscar, criterio)
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
								<th>Sueldo</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="empleado in arrayEmpleado"
								:key="empleado.id"
							>
								<td>
									<button
										type="button"
										@click="
											abrirModal(
												'empleado',
												'actualizar',
												empleado
											)
										"
										class="btn btn-warning btn-sm"
									>
										<i class="icon-pencil"></i>
									</button>
									&nbsp;
									<template v-if="empleado.condicion">
										<button
											type="button"
											@click="
												desactivarEmpleado(empleado.id)
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
												activarEmpleado(empleado.id)
											"
											class="btn btn-info btn-sm"
										>
											<i class="icon-check"></i>
										</button>
									</template>
								</td>
								<td v-text="empleado.nombre"></td>
								<td v-text="empleado.tipo_documento"></td>
								<td v-text="empleado.num_documento"></td>
								<td v-text="empleado.direccion"></td>
								<td v-text="empleado.telefono"></td>
								<td v-text="empleado.email"></td>
								<td v-text="empleado.sueldo"></td>
								<td>
									<div v-if="empleado.condicion">
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
										placeholder="Nombre del empleado"
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
							<div class="form-group row">
								<label
									class="col-md-3 form-control-label"
									for="text-input"
									>Sueldo</label
								>
								<div class="col-md-9">
									<el-input
										placeholder="sueldo"
										v-model.number="sueldo"
									></el-input>
								</div>
							</div>

							<div
								v-show="errorEmpleado"
								class="form-group row div-error"
							>
								<div class="text-center text-error">
									<div
										v-for="error in errorMostrarMsjEmpleado"
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
							@click="registrarEmpleado()"
						>
							Guardar
						</button>
						<button
							type="button"
							v-if="tipoAccion == 2"
							class="btn btn-primary"
							@click="actualizarEmpleado()"
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
			empleado_id: 0,
			nombre: "",
			tipo_documento: "DUI",
			num_documento: "",
			direccion: "",
			telefono: "",
			email: "",
			sueldo: "",
			arrayEmpleado: [],
			modal: 0,
			tituloModal: "",
			tipoAccion: 0,
			errorEmpleado: 0,
			errorMostrarMsjEmpleado: [],
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
				message: "Empleado Guardado con éxito.",
				type: "success",
			});
		},
		editar() {
			this.$message({
				message: "Empleado Actualizado con éxito.",
				type: "success",
			});
		},
		listarEmpleado(page, buscar, criterio) {
			let me = this;
			var url =
				"/empleado?page=" +
				page +
				"&buscar=" +
				buscar +
				"&criterio=" +
				criterio;
			axios
				.get(url)
				.then(function (response) {
					var respuesta = response.data;
					me.arrayEmpleado = respuesta.empleados.data;
					me.pagination = respuesta.pagination;
				})
				.catch(function (error) {
					console.log(error);
				});
		},
		cambiarPagina(page, buscar, criterio) {
			let me = this;
			me.pagination.current_page = page;
			me.listarEmpleado(page, buscar, criterio);
		},
		registrarEmpleado() {
			//validando campos categoria
			if (this.validarEmpleado()) {
				return;
			}

			let me = this;

			axios
				.post("/empleado/registrar", {
					nombre: this.nombre,
					tipo_documento: this.tipo_documento,
					num_documento: this.num_documento,
					direccion: this.direccion,
					telefono: this.telefono,
					email: this.email,
					sueldo: this.sueldo,
				})
				.then(function (response) {
					me.cerrarModal();
					me.listarEmpleado(1, "", "nombre");
					me.guardar();
				})
				.catch(function (error) {
					console.log(error);
				});
		},
		actualizarEmpleado() {
			//validando campos categoria
			if (this.validarEmpleado()) {
				return;
			}

			let me = this;
			axios
				.put("/empleado/actualizar", {
					nombre: this.nombre,
					tipo_documento: this.tipo_documento,
					num_documento: this.num_documento,
					direccion: this.direccion,
					telefono: this.telefono,
					email: this.email,
					sueldo: this.sueldo,
					id: this.empleado_id,
				})
				.then(function (response) {
					me.cerrarModal();
					me.listarEmpleado(1, "", "nombre");
					me.editar();
				})
				.catch(function (error) {
					console.log(error);
				});
		},
		desactivarEmpleado(id) {
			Swal.fire({
				title: "Estas seguro de desactivar este empleado?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Aceptar",
			}).then((result) => {
				if (result.value) {
					let me = this;
					axios
						.put("/empleado/desactivar", {
							id: id,
						})
						.then(function (response) {
							me.listarEmpleado(1, "", "nombre");
						})
						.catch(function (error) {
							console.log(error);
						});
				}
			});
		},
		activarEmpleado(id) {
			Swal.fire({
				title: "Estas seguro de activar este empleado?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Aceptar",
			}).then((result) => {
				if (result.value) {
					let me = this;
					axios
						.put("/empleado/activar", {
							id: id,
						})
						.then(function (response) {
							Swal.fire(
								"Activado!",
								"El registro ha sido desactivado con éxito.",
								"success"
							);
							me.listarEmpleado(1, "", "nombre");
						})
						.catch(function (error) {
							console.log(error);
						});
				}
			});
		},

		validarEmpleado() {
			this.errorProveedor = 0;
			this.errorMostrarMsjEmpleado = [];

			if (!this.nombre)
				this.errorMostrarMsjEmpleado.push(
					"El nombre de la proveedor no puede estar vacío."
				);

			if (this.errorMostrarMsjEmpleado.length) this.errorEmpleado = 1;

			return this.errorEmpleado;
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
			this.sueldo = "";
			this.errorProveedor = 0;
		},
		abrirModal(modelo, accion, data = []) {
			switch (modelo) {
				case "empleado": {
					switch (accion) {
						case "registrar": {
							this.modal = 1;
							this.tituloModal = "Registrar Empleado";
							this.nombre = "";
							this.tipo_documento = "NIT";
							this.num_documento = "";
							this.direccion = "";
							this.telefono = "";
							this.email = "";
							this.sueldo = "";
							this.tipoAccion = 1;
							break;
						}
						case "actualizar": {
							this.modal = 1;
							this.tituloModal = "Actualizar empelado";
							this.tipoAccion = 2;
							this.empleado_id = data["id"];
							this.nombre = data["nombre"];
							this.tipo_documento = data["tipo_documento"];
							this.num_documento = data["num_documento"];
							this.direccion = data["direccion"];
							this.telefono = data["telefono"];
							this.email = data["email"];
							this.sueldo = data["sueldo"];

							break;
						}
					}
				}
			}
		},
	},
	mounted() {
		this.listarEmpleado(1, this.buscar, this.criterio);
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
