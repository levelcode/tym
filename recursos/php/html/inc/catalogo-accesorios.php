<div id="catalogo-accesorios" ng-controller="productListHeader">
	<div class="catalogo">
		<span class="cerrar">x</span>
		<i class="indicador"></i>
		<div class="contenido">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-10" ng-cloak>
						<p class="txt-13 text-right text-uppercase"><span class="c-color3">Escogiste:</span> {{selectedCar.vehicle.brand}} / {{selectedCar.model.model}} / {{selectedCar.year}}</p>
						<section id="accesorio" ng-controller="productListCtrl">
							<div class="text-center" ng-if="!productsLoaded">
								<br>
								<p class="txt-16">cargando...</p>
								<br>
								<img src="recursos/img/preloader-productos.gif" alt="">
							</div>
							<!-- product of type rin -->
							<div ng-if="rinProductsSelected" >

								<div ng-if="rinEmpty">
									<h1 class="titulo text-uppercase">Rines</h1>
									<hr>
									<div class="alert alert-info bg-color4">
						            	<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
						            </div>
								</div>
								<div ng-if="!rinEmpty" ng-repeat="(key, value) in rinProducts">
									<h1 class="titulo text-uppercase">Rines {{key}} pulgadas</h1>
									<hr>
									<div class="row">
										<div ng-repeat="(key1, product) in value.rines" class="col-sm-6 col-md-4">
											<a class="producto" ng-click="sendToProductDetail( product, 'rin' )">
												<div class="row">
													<div class="col-xs-6">
														<img ng-src="admin/recursos/img/rin-products/{{product.img}}.gif" alt="" class="img-responsive">
													</div>
													<div class="col-xs-6">
														{{product.brand}}<br>
														<i class="txt-12 c-color1" ng-bind="product.brand+' '+product.referencie"></i>
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							</div>
							<!-- product of type rin -->
							<!-- product of type tire -->
							<div ng-if="tireProductsSelected" >
								<div ng-if="tireEmpty">
									<h1 class="titulo text-uppercase">Llantas</h1>
									<hr>
									<div class="alert alert-info bg-color4">
						            	<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
						            </div>
								</div>

								<div ng-if="!tireEmpty" ng-repeat="(key, product) in tireProducts">
									<h1 class="titulo text-uppercase">Llantas para Rines de {{key}} pulgadas</h1>
									<hr>
									<div class="row">
										<div ng-repeat="(key1, product) in product.tires" class="col-sm-6 col-md-4">
											<a class="producto" ng-click="sendToProductDetail( product, 'tire' )">
												<div class="row">
													<div class="col-xs-6">
														<img ng-src="admin/recursos/img/tire-products/{{product.img}}.gif" alt="" class="img-responsive">
													</div>
													<div class="col-xs-6">
														{{product.brand}}<br>
														<i class="txt-12 c-color1" ng-bind="product.referencie"></i>
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							</div>
							<!-- product of type tire -->
							<div ng-if="bomperestribosProductsSelected" ng-repeat="(key, productGroup) in bomperestribosProducts">
								<h1 class="titulo text-uppercase"><span ng-if="key == 'delantero' || key == 'trasero'">Bomper</span> {{key}}</h1>
								<hr>
								<div ng-if="bomperestribosEmpty">
									<div class="alert alert-info bg-color4">
						            	<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
						            </div>
								</div>
								<div class="row" ng-if="!bomperestribosEmpty">
									<div ng-repeat="(key1, product) in productGroup" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'bomperestribos' )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="admin/recursos/img/bomperestribos-products/{{product.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-12 c-color1" ng-bind="product.referencie"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type seat -->
							<div ng-if="portaequipajesProductsSelected" >
								<h1 class="titulo text-uppercase">Portaequipajes</h1>
								<hr>
								<div ng-if="portaequipajesEmpty">
									<div class="alert alert-info bg-color4">
						            	<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
						            </div>
								</div>
								<div class="row" ng-if="!portaequipajesEmpty">
									<div ng-repeat="(key, product) in portaequipajesProducts" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'portaequipaje' )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="admin/recursos/img/portaequipajes-products/{{product.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-12 c-color1" ng-bind="product.referencie"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type seat -->
							<!-- product of type light -->
							<div ng-if="barrasTechoProductsSelected" >
								<h1 class="titulo text-uppercase">Barras de techo</h1>
								<hr>
								<div ng-if="barrastechoEmpty">
									<div class="alert alert-info bg-color4">
						            	<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
						            </div>
								</div>
								<div class="row" ng-if="!barrastechoEmpty">
									<div ng-repeat="(key, product) in lightProducts" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'light_hid' )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="admin/recursos/img/light-hid-products/{{product.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-12 c-color1" ng-bind="product.referencie"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type light -->
							<!-- product of type tank -->
							<div ng-if="bicicleterosProductsSelected" >
								<h1 class="titulo text-uppercase">Bicicleteros</h1>
								<hr>
								<div ng-if="bicicleterosEmpty">
									<div class="alert alert-info bg-color4">
										<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
									</div>
								</div>
								<div class="row" ng-if="!bicicleterosEmpty">
									<div ng-repeat="(key, product) in tankProducts" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'tank' )">
											<div class="row">
												<div class="col-xs-6">
													<!-- <img ng-src="admin/recursos/img/tank-products/{{product.img}}.gif" alt="" class="img-responsive"> -->
													<img ng-src="recursos/img/foto-rin-01.jpg" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-12 c-color1" ng-bind="product.referencie"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type tank -->
							<!-- product of type tank -->
							<div ng-if="parrillastechoProductsSelected" >
								<h1 class="titulo text-uppercase">Parrilas de techo</h1>
								<hr>
								<div ng-if="parrillastechoEmpty">
									<div class="alert alert-info bg-color4">
										<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
									</div>
								</div>
								<div class="row" ng-if="!parrillastechoEmpty">
									<div ng-repeat="(key, product) in tankProducts" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'tank' )">
											<div class="row">
												<div class="col-xs-6">
													<!-- <img ng-src="admin/recursos/img/tank-products/{{product.img}}.gif" alt="" class="img-responsive"> -->
													<img ng-src="recursos/img/foto-rin-01.jpg" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-12 c-color1" ng-bind="product.referencie"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type tank -->
							<!-- product of type tank -->
							<div ng-if="accesoriosProductsSelected" ng-repeat="(key, productGroup) in universalProducts" >
								<h1 class="titulo text-uppercase" id="{{key}}">Accesorios {{key}}</h1>
								<hr>
								<div class="row" ng-if="!accesorios4x4Empty">
									<div ng-repeat="(key, product) in productGroup" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'tank' )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="admin/recursos/img/accesorios/universales/{{product.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-12 c-color1" ng-bind="product.referencie"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type tank -->
						</section>
					</div>
					<div class="col-sm-2 text-center te-puede-interesar">
						<h5 class="text-uppercase txt-18 c-color4">Te puede interesar</h5>
						<i class="st-separador"></i>

						<div class="tipo">
							<div class="cuadro">
								<span><a class="accesorios">Tapete maletero</a></span>
								<a href="#plumillas" data-nombre="accesorios-accesorios" style="margin-top: 10px;" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
							</div>
							<div class="foto img1">

							</div>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Pijamas para vehiculos</span>
								<a href="" style="margin-top: 10px;" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
							</div>
							<div class="foto img2">
							</div>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Plumillas universales</span>
								<a href="#plumillas" style="margin-top: 10px;" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
							</div>
							<div class="foto img3">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
