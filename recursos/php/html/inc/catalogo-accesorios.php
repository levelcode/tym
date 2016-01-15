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
								<div ng-repeat="(key, value) in rinProducts">
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
								<h1 class="titulo text-uppercase">Llantas</h1>
								<hr>
								<div class="row">
									<div ng-repeat="(key, product) in tireProducts" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( product, 'tire' )">
											<div class="row">
												<div class="col-xs-6">
													<!-- <img ng-src="admin/recursos/img/tire-products/{{product.img}}.gif" alt="" class="img-responsive"> -->
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
							<!-- product of type tire -->
						</section>
					</div>
					<div class="col-sm-2 text-center te-puede-interesar">
						<h5 class="text-uppercase txt-18 c-color4">Te puede interesar</h5>
						<i class="st-separador"></i>

						<div class="tipo">
							<div class="cuadro">
								<span>Tanques</span>
							</div>
							<div class="foto img1">
								<a href="" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
							</div>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Racks</span>
							</div>
							<div class="foto img2">
								<a href="" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
							</div>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Bicicleteros</span>
							</div>
							<div class="foto img3">
								<a href="" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
