<div id="catalogo-accesorios" ng-controller="productListHeader">
	<div class="catalogo">
		<span class="cerrar">x</span>
		<i class="indicador" style="border-color: transparent rgb(225, 21, 22) transparent transparent;"></i>
		<div class="contenido">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-10" ng-cloak>
						<p class="txt-20 text-right text-uppercase"><span class="c-color3">Escogiste:</span> {{selectedCar.vehicle.brand}} / {{selectedCar.model.model}} / {{selectedCar.year}}</p>
						<section id="accesorio" ng-controller="productListCtrl">
							<div class="text-center" ng-if="!productsLoaded">
								<br>
								<p class="txt-16">cargando...</p>
								<br>
								<img src="/recursos/img/preloader-productos.gif" alt="">
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
														<img ng-src="/admin/recursos/img/rin-products/{{product.img}}.gif" alt="" class="img-responsive">
													</div>
													<div class="col-xs-6">
														{{product.brand}}<br>
														<i class="txt-14 c-color1" ng-bind="(product.price_client)|currency : '$ ' : 0"></i>
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
														<img ng-src="/admin/recursos/img/tire-products/{{product.img}}.gif" alt="" class="img-responsive">
													</div>
													<div class="col-xs-6">
														{{product.brand}}<br>
														<i class="txt-14 c-color1" ng-bind="(product.price)|currency : '$ ' : 0"></i>
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							</div>
							<!-- product of type Bomper y estribos -->
							<div ng-if="bomperestribosProductsSelected" ng-repeat="(key, productGroup) in bomperestribosProducts">
								<h1 class="titulo text-uppercase"><span ng-if="key == 'delantero' || key == 'trasero'">Bomper</span> {{key}}</h1>
								<hr>
								<div ng-if="productGroup.length == undefined || productGroup.length == 0">
									<div class="alert alert-info bg-color4">
						            	<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
						            </div>
								</div>
								<div class="row" ng-if="productGroup.length > 0">
									<div ng-repeat="(key1, product) in productGroup" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'bomperestribos', key )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="/admin/recursos/img/bomperestribos-products/{{product.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-14 c-color1" ng-bind="(product.price)|currency : '$ ' : 0"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type Bomper y estribos -->
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
										<a class="producto" ng-click="sendToProductDetail( product, 'portaequipajes' )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="/admin/recursos/img/portaequipajes-products/{{product.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-14 c-color1" ng-bind="(product.price)|currency : '$ ' : 0"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type seat -->
							<!-- product of type light -->
							<div ng-if="barrasTechoProductsSelected" ng-repeat="(key, productGroup) in barrasTechoProducts">
								<h1 class="titulo text-uppercase">{{key}}</h1>
								<hr>
								<div ng-if="productGroup.length == undefined || productGroup.length == 0">
									<div class="alert alert-info bg-color4">
						            	<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
						            </div>
								</div>
								<div class="row" ng-if="productGroup.length > 0">
									<div ng-repeat="(key1, product) in productGroup" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'barras', key )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="/admin/recursos/img/barras-products/{{product.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-14 c-color1" ng-bind="(product.price)|currency : '$ ' : 0"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type light -->

							<!-- product of type parrillas -->
							<div ng-if="parrillastechoProductsSelected" >
								<h1 class="titulo text-uppercase">Parrilas de techo</h1>
								<hr>
								<div ng-if="parrillasTechoProductsEmpty">
									<div class="alert alert-info bg-color4">
										<i>En este momento no contamos con este producto para tu vehiculo, pero encuentra otros productos haciendo click en otras categorias.</i>
									</div>
								</div>
								<div class="row" ng-if="!parrillasTechoProductsEmpty">
									<div ng-repeat="(key, product) in parrillasTechoProducts" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'parrillas' )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="/admin/recursos/img/parrillas-products/{{product.img}}.gif" alt="" class="img-responsive">
													<!-- <img ng-src="recursos/img/foto-rin-01.jpg" alt="" class="img-responsive"> -->
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-14 c-color1" ng-bind="(product.price)|currency : '$ ' : 0"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type parrillas -->
							<!-- product of type accesorios -->
							<div ng-if="accesoriosProductsSelected" ng-repeat="(keyMain, productGroup) in universalProducts" >
								<h1 class="titulo text-uppercase" id="{{keyMain | spaceless}}">{{keyMain}}</h1>
								<hr>
								<div class="row" ng-if="!accesorios4x4Empty">
									<div ng-repeat="(key, product) in productGroup" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'accesorios', keyMain )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="/admin/recursos/img/accesorios/{{keyMain}}-products/{{product.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{product.brand}}<br>
													<i class="txt-14 c-color1" ng-bind="(product.price)|currency : '$ ' : 0"></i>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
							<!-- product of type accesorios -->
						</section>
					</div>
					<div class="col-sm-2 text-center te-puede-interesar">
						<h5 class="text-uppercase txt-18 c-color4">Te puede interesar</h5>
						<i class="st-separador"></i>
						<div class="tipo" ng-repeat="(key, value) in interestYouItems">
							<div class="cuadro">
								<span class="accesorios" ng-bind="value.data.custom_message"></span><br>
								<a ng-click="sendToProductDetail( value.data, value.data.category_aux )" style="margin-top: 10px;" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar Ahora</a>
							</div>
							<div class="foto">
								<img ng-if="value.data.category_aux == 'kit completo' || value.data.category_aux == 'marco placa' || value.data.category_aux == 'rejilla frontal' || value.data.category_aux == 'cubierta stops traseros' || value.data.category_aux == 'exploradoras' || value.data.category_aux == 'barra de exploradoras' || value.data.category_aux == 'tanques' || value.data.category_aux == 'barra antivolco' || value.data.category_aux == 'plumillas' || value.data.category_aux == 'barra luces led' || value.data.category_aux == 'portabicicleta' || value.data.category_aux == 'portabicicleta de techo' || value.data.category_aux == 'filtro de aire' || value.data.category_aux == 'pijamas para vehiculos' || value.data.category_aux == 'pitos' || value.data.category_aux == 'reflejo logo' || value.data.category_aux == 'rines ciegos' || value.data.category_aux == 'tapete maletero'" ng-src="/admin/recursos/img/accesorios/{{value.data.category_aux}}-products/{{value.data.img}}.gif" alt="" class="img-responsive">
								<img ng-if="value.data.category_aux != 'kit completo' && value.data.category_aux != 'marco placa' && value.data.category_aux != 'rejilla frontal' && value.data.category_aux != 'cubierta stops traseros' && value.data.category_aux != 'exploradoras' && value.data.category_aux != 'barra de exploradoras' && value.data.category_aux != 'tanques' && value.data.category_aux != 'barra antivolco' && value.data.category_aux != 'plumillas' && value.data.category_aux != 'barra luces led' && value.data.category_aux != 'portabicicleta' && value.data.category_aux != 'portabicicleta de techo' && value.data.category_aux != 'filtro de aire' && value.data.category_aux != 'pijamas para vehiculos' && value.data.category_aux != 'pitos' && value.data.category_aux != 'reflejo logo' && value.data.category_aux != 'rines ciegos' && value.data.category_aux != 'tapete maletero'" ng-src="/admin/recursos/img/{{value.data.category_aux}}-products/{{value.data.img}}.gif" alt="" class="img-responsive">
							</div>
						</div>
						<!-- <div class="tipo">
							<div class="cuadro">
								<span>Pijamas para vehiculos</span>
								<a href="" data-producto-nombre="pijamas-para-vehiculos" style="margin-top: 10px;"  ng-click="openProductType('accesorios')" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
							</div>
							<div class="foto img2">
							</div>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Plumillas universales</span>
								<a href="#plumillas" data-producto-nombre="plumillas" style="margin-top: 10px;"  ng-click="openProductType('accesorios')" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
							</div>
							<div class="foto img3">
							</div>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
