<div id="catalogo-accesorios" ng-controller="productListHeader">
	<div class="catalogo">
		<i class="indicador"></i>
		<div class="contenido">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-10" ng-cloak>
						<p class="txt-13 text-right"><span class="c-color3">Escogiste:</span> {{selectedCar.vehicle.brand}} / {{selectedCar.model.model}} / {{selectedCar.year}}</p>
						<section id="accesorio" ng-controller="productListCtrl">
							<div class="text-center" ng-if="!rinesLoaded">
								<br>
								<p class="txt-24">Selecciona tu vehiculo</p>
								<br>
								<!--<img src="recursos/img/preloader-productos.gif" alt="">-->
							</div>
							<div ng-if="rinProducts" >
								<h1 class="titulo text-uppercase">Rines</h1>
								<hr>
								<div class="row" >
									<div ng-repeat="value in rinProducts" class="col-sm-6 col-md-4">
										<a class="producto" ng-click="sendToProductDetail( value )">
											<div class="row">
												<div class="col-xs-6">
													<img ng-src="admin/recursos/img/rin-products/{{value.img}}.gif" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													{{value.brand}}<br>
													<i class="txt-12 c-color1" ng-bind="value.brand+' '+value.referencie"></i>
												</div>
											</div>
										</a>
									</div>
								</div>

								<!--<h1 class="titulo text-uppercase">Rines 14pulgadas</h1>
								<hr>
								<div class="row">
									<div class="col-sm-6 col-md-4">
										<a class="producto">
											<div class="row">
												<div class="col-xs-6">
													<img src="recursos/img/foto-rin-01.jpg" alt="" class="img-responsive">
												</div>
												<div class="col-xs-6">
													MS-101<br>
													<i class="txt-12 c-color1">Yueling 7618 B-P</i>
												</div>
											</div>
										</a>
									</div>
								</div>-->
							</div>
						</section>
					</div>
					<div class="col-sm-2 text-center">
						<h5 class="text-uppercase txt-18 c-color4">Te puede interesar</h5>
						<i class="st-separador"></i>

						<div class="tipo">
							<div class="cuadro">
								<span>Tanques</span>
							</div>
							<div class="foto">
								<img src="recursos/img/img-tanques.jpg" alt="" class="img-responsive">
							</div>
							<a href="" class="btn text-uppercase btn-info c-blanco">Comprar<br>Ahora</a>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Racks</span>
							</div>
							<div class="foto">
								<img src="recursos/img/img-racks.jpg" alt="" class="img-responsive">
							</div>
							<a href="" class="btn text-uppercase btn-info c-blanco">Comprar<br>Ahora</a>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Bicicleteros</span>
							</div>
							<div class="foto">
								<img src="recursos/img/img-bicicleteros.jpg" alt="" class="img-responsive">
							</div>
							<a href="" class="btn text-uppercase btn-info c-blanco">Comprar<br>Ahora</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
