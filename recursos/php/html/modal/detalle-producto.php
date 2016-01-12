<div id="detalle-producto" ng-controller="productDetailCtrl">
	<div class="container">
		<div class="cerrar"></div>
		<row>
			<div class="col-sm-10" ng-cloak>
				<div class="row">
					<div class="col-sm-6">
						<p class="txt-13"><span class="c-color3">Escogiste:</span> {{selectedCar.vehicle.brand}} / {{selectedCar.model.model}} / {{selectedCar.year}}</p>
					</div>
					<div class="col-sm-6">
						<p class="txt-13">Valora este artículo: &nbsp;<i class="st-calificacion valor-0"></i> | Votos (0)</p>
					</div>
				</div>

				<div class="row producto">
					<div class="col-sm-6">
						<div class="imagen">
							<img ng-src="admin/recursos/img/rin-products/{{selectedProduct.img}}.gif" alt="" class="img-responsive">
						</div>
					</div>
					<div class="col-sm-6">
						<span class="nombre" ng-bind="selectedProduct.brand">7618</span><br>
						<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
						<br>
						<br>
						<div class="row">
							<div class="col-xs-6">
								<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
								<br>
								<br>
								<span class="c-color4">Tamaño:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.diameter}}" {{selectedProduct.width}}</b><br>
								<span class="c-color4">PCD:</span> <b class="pcd c-blanco txt-18">{{selectedProduct.pcd}}</b><br>
								<!--<span class="c-color4">ET:</span> <b class="et c-blanco txt-18">35</b><br>
								<span class="c-color4">CB:</span> <b class="cb c-blanco txt-18">73.1</b>-->
							</div>
							<div class="col-xs-6 text-right">
								<br>
								<br>
								<span class="c-color3 text-uppercase">Precio por rin</span><br>
								$<b class="precio txt-24" ng-bind="(selectedProduct.price_client) | currency : '$' : 0"></b><br>
								<span class="c-color3 text-uppercase">Set x 4:</span><br>
								$<b class="precio txt-20" ng-bind="(selectedProduct.price_client) | currency : '$' : 0">1.800.000</b>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12">
								<span class="c-color3 text-uppercase">Compatible con los siguientes modelos</span>
								<br>
								<div class="form-group">
									<select name="" id="" class="form-control">
										<option value="">Seleccione Marca</option>
										<option value="">Chevrolet</option>
										<option value="">Hyundai</option>
										<option value="">Mazda</option>
										<option value="">Renault</option>
										<option value="">BMW</option>
										<option value="">Mercedes</option>
										<option value="">Ford</option>
									</select>
								</div>
							</div>
							<div class="col-xs-12 text-right">
								<button ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.details, 1, selectedProduct.price_client, 0, 0)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-2 text-center">
				<h5 class="text-uppercase">Te puede interesar</h5>
				<i class="st-separador"></i>
			</div>
		</row>
	</div>
</div>
