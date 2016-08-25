<!-- Cabecero -->
<?php
require_once('recursos/php/config.php');

$opciones = array(
	'responsivo' => true,
	'descripcion' => 'La descripción aquí',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Descripción del producto - '._TITULO,
	'css' => array(
		'recursos/css/descripcion-producto.css'
	),
	'js' => array(
		'/recursos/js/angular.min.js',
		'/recursos/js/ui-bootstrap-tpls-0.13.4.min.js',
		'/recursos/js/angular-cookies.min.js',
		'/recursos/js/ng-file-upload/ng-file-upload.min.js',
		'/recursos/js/angular-sanitize.min.js'
	)
);

$cabecero = new html\Cabecero($opciones);


?>

<!-- contenido -->
		<div id="contenido">
			<input type="hidden" name="queryString" ng-model="queryString" ng-init="queryString = '?<?= $_SERVER['QUERY_STRING'];?>'">
			<div id="titulo">
				<h1 class="text-uppercase">Descripción producto</h1>
			</div>

			<section id="slider">
				<div class="container">
					<div class="row">
						<div id="detalle-producto" ng-controller="productDetailCtrl">
							<div class="container">
								<row>
									<div class="col-sm-10" ng-cloak>
										<div class="row">
											<div class="col-sm-6">
												<p class="txt-18 text-uppercase"><span class="c-color3">Escogiste:</span> {{selectedCar.vehicle.brand}} / {{selectedCar.model.model}} / {{selectedCar.year}}</p>
											</div>
											<div class="col-sm-6">
												<!-- <p class="txt-13">Valora este artículo: &nbsp;<i class="st-calificacion valor-0"></i> | Votos (0)</p> -->
											</div>
										</div>
										<!-- rin -->
										<div ng-if="selectedProductType == 'rin'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="/admin/recursos/img/{{response.type}}-products/{{selectedProduct.id}}/{{selectedProduct.img}}" alt="" class="img-responsive">
												</div>
												<br>
												<div class="row">
													<div class="col-sm-3 thumbnail-option" ng-repeat="imgItem in selectedProductImages">
														<div class="imagen">
															<img ng-src="/admin/recursos/img/{{response.type}}-products/{{selectedProduct.id}}/{{imgItem}}" alt="" class="img-responsive"  ng-click="changeImage(imgItem)" ng-class="{'thumbnail-option-active': selectedProduct.img == imgItem }">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" style="text-transform: uppercase;"ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-7">
														<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
														<br>
														<br>
														<span class="c-color4">Tamaño:</span> <b class="tamano c-blanco txt-15" >{{selectedProduct.diameter}}" {{selectedProduct.width}}</b><br>
														<span class="c-color4">PCD:</span> <b class="pcd c-blanco txt-15">{{selectedProduct.pcd}}</b><br>
														<span class="c-color4">Color:</span> <b class="et c-blanco txt-15" ng-bind="selectedProduct.color"></b><br>
														<span class="c-color4">Tipo:</span> <b class="cb c-blanco txt-15" ng-bind="selectedProduct.type"></b><br>
														<span class="c-color4">Material:</span> <b class="cb c-blanco txt-15" ng-bind="selectedProduct.material"></b><br>
														<span class="c-color4" ng-if="selectedProduct.has_instructivo == 'si'">Instructivo:</span> <a ng-if="selectedProduct.has_instructivo == 'si'" href="admin/recursos/documents/instructivos/{{selectedProductType}}.pdf" target="_blank" class="tamano c-blanco txt-18" >Descargar</a><br>
													</div>
													<div class="col-xs-5 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio por rin</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price_client) | currency : '$' : 0"></b><br>
														<!-- <span class="c-color3 text-uppercase">Set x 4:</span><br>
														<b class="precio txt-20" ng-bind="(selectedProduct.price_client) | currency : '$' : 0"></b> -->
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12">
														<span class="c-color3 text-uppercase">Descripción:</span><br>
														<b class="precio txt-15" ng-bind-html="selectedProduct.details"></b><br>
														<!-- <span class="c-color3 text-uppercase">Compatible con los siguientes modelos</span> -->
														<br>
														<br>
														<br>
													</div>
													<div class="col-xs-12 text-right">
														<button ng-disabled="selectedProduct.stock_unit == 0" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.details, 1, selectedProduct.price_client, 0, 0, selectedProduct.img, 'rin', selectedProduct.size, selectedProduct )" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
											<div class="row" >
												<div class="col-md-12">
													<br>
													<div class="alert alert-info bg-color4" ng-if="selectedProduct.is_blind == '1'">
														<i>Instructivo: TYM ha importado rines ciegos de la marca autraliana PDW con los más altos estándares de caildad, estos rines no tienen huecos, por lo tanto, se puede realizar la perforación de los mismoa a la medida técnica que necesite su vehículo. esta perforación o barrenación la realiza TYM y tiene un costo adicional.<br>Los Rines ciegos disponiblrs son de fiámetro 15 y 16 pulgadas y de 8 pulgadas de ancho.</i>
													</div>
												</div>
											</div>
										</div>
										<!-- rin -->
										<!-- tire -->
										<div ng-if="selectedProductType == 'tire'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="/admin/recursos/img/{{response.type}}-products/{{selectedProduct.id}}/{{selectedProduct.img}}" alt="" class="img-responsive">
												</div>
												<br>
												<div class="row">
													<div class="col-sm-3 thumbnail-option" ng-repeat="imgItem in selectedProductImages">
														<div class="imagen">
															<img ng-src="/admin/recursos/img/{{response.type}}-products/{{selectedProduct.id}}/{{imgItem}}" alt="" class="img-responsive"  ng-click="changeImage(imgItem)" ng-class="{'thumbnail-option-active': selectedProduct.img == imgItem }">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-8">
														<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
														<br>
														<br>
														<span class="c-color4">Llanta:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.type}}</b><br>
														<span class="c-color4">Marca:</span> <b class="pcd c-blanco txt-18">{{selectedProduct.brand}}</b><br>
														<span class="c-color4">Modelo:</span> <b class="et c-blanco txt-18">{{selectedProduct.model}}</b><br>
														<span class="c-color4">Indice de velocidad:</span> <b class="cb c-blanco txt-18">{{selectedProduct.speed_rate + '(Km/h)'}}</b><br>
														<span class="c-color4">Indice de carga:</span> <b class="cb c-blanco txt-18">{{selectedProduct.weigth_rate + '(Kg)'}}</b><br>
														<span class="c-color4">Para rines de ancho:</span> <b class="cb c-blanco txt-18">{{selectedProduct.inches + '\"'}}</b>
													</div>
													<div class="col-xs-4 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio por llanta</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
														<!-- <span class="c-color3 text-uppercase">Set x 4:</span><br> -->
														<!-- <b class="precio txt-20" ng-bind="(selectedProduct.price_group) | currency : '$' : 0"></b> -->
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12">
														<br>
														<br>
														<br>
													</div>
													<div class="col-xs-12 text-right">
														<button ng-disabled="selectedProduct.stock_unit == 0" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, 'tire', selectedProduct.size, selectedProduct)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
										</div>
										<!-- tire -->
										<!-- barras -->
										<div ng-if="selectedProductType == 'barras'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="/admin/recursos/img/{{selectedProductType}}-products/{{response.subType}}/{{selectedProduct.id}}/{{selectedProduct.img}}" alt="" class="img-responsive">
													<!-- <img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive"> -->
												</div>
												<br>
												<div class="row">
													<div class="col-sm-3 thumbnail-option" ng-repeat="imgItem in selectedProductImages">
														<div class="imagen">
															<img ng-src="/admin/recursos/img/{{response.type}}-products/{{response.subType}}/{{selectedProduct.id}}/{{imgItem}}" alt="" class="img-responsive"  ng-click="changeImage(imgItem)" ng-class="{'thumbnail-option-active': selectedProduct.img == imgItem }">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-7">
														<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
														<br>
														<br>
														<span class="c-color4">Caracteristica:</span> <b class="precio txt-15" ng-bind-html="selectedProduct.detail" ></b><br>
														<span class="c-color4">Material:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.material}}</b><br>
														<span class="c-color4" ng-if="selectedProduct.has_instructivo == 'si'">Instructivo:</span> <a ng-if="selectedProduct.has_instructivo == 'si'" href="admin/recursos/documents/instructivos/porta_equipaje.pdf" target="_blank" class="tamano c-blanco txt-18" >Descargar</a><br>
													</div>
													<div class="col-xs-5 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12">
														<br>
														<br>
														<br>
													</div>
													<div class="col-xs-12 text-right">
														<button ng-disabled="selectedProduct.stock_unit == 0" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, selectedProductType, selectedProduct.size, selectedProduct)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
										</div>
										<!-- barras -->
										<!-- parrillas -->
										<div ng-if="selectedProductType == 'parrillas'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="/admin/recursos/img/{{selectedProductType}}-products/{{selectedProduct.id}}/{{selectedProduct.img}}" alt="" class="img-responsive">
													<!-- <img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive"> -->
												</div>
												<br>
												<div class="row">
													<div class="col-sm-3 thumbnail-option" ng-repeat="imgItem in selectedProductImages">
														<div class="imagen">
															<img ng-src="/admin/recursos/img/{{response.type}}-products/{{selectedProduct.id}}/{{imgItem}}" alt="" class="img-responsive"  ng-click="changeImage(imgItem)" ng-class="{'thumbnail-option-active': selectedProduct.img == imgItem }">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-7">
														<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
														<br>
														<br>
														<span class="c-color4">Talla:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.size_in}}</b><br>
														<span class="c-color4">Caracteristica:</span> <b class="precio txt-15" ng-bind-html="selectedProduct.details"></b><br>
														<span class="c-color4">Color:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.color}}</b><br>
														<span class="c-color4" ng-if="selectedProduct.has_instructivo == 'si'">Instructivo:</span> <a ng-if="selectedProduct.has_instructivo == 'si'" href="admin/recursos/documents/instructivos/porta_equipaje.pdf" target="_blank" class="tamano c-blanco txt-18" >Descargar</a><br>
													</div>
													<div class="col-xs-5 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12">
														<br>
														<br>
														<br>
													</div>
													<div class="col-xs-12 text-right">
														<button ng-disabled="selectedProduct.stock == 0" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, selectedProductType, selectedProduct.size, selectedProduct)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
										</div>
										<!-- parrillas -->
										<!-- bomper -->
										<div ng-if="selectedProductType == 'bomperestribos'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="/admin/recursos/img/{{response.type}}-products/{{response.subType}}/{{selectedProduct.id}}/{{selectedProduct.img}}" alt="" class="img-responsive">
												</div>
												<br>
												<div class="row">
													<div class="col-sm-3 thumbnail-option" ng-repeat="imgItem in selectedProductImages">
														<div class="imagen">
															<img ng-src="/admin/recursos/img/{{response.type}}-products/{{response.subType}}/{{selectedProduct.id}}/{{imgItem}}" alt="" class="img-responsive"  ng-click="changeImage(imgItem)" ng-class="{'thumbnail-option-active': selectedProduct.img == imgItem }">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-7">
														<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock"></b></span>
														<br>
														<br>
														<span class="c-color4" ng-if="selectedProduct.instructivo == 'si'">Instructivo:</span> <a href="admin/recursos/documents/instructivos/bomper/bompers.pdf" target="_blank" class="tamano c-blanco txt-18" >Descargar</a><br>
													</div>
													<div class="col-xs-5 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
													</div>
													<div class="col-md-12">
														<br>
														<br>
														<br>
														<span class="c-color4">Caracteristica:</span> <b class="precio txt-15" ng-bind-html="selectedProduct.detail" ></b><br>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12">
														<br>
														<br>
														<br>
													</div>
													<div class="col-xs-12 text-right">
														<button ng-disabled="selectedProduct.stock == 0" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, selectedProductType, selectedProduct.size, selectedProduct)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
											<div class="row" >
												<div class="col-md-12">
													<br>
													<div class="alert alert-info bg-color4">
														<i>Instructivo: Los bompers tanto delantero como trasero y estribos, están diseñados acorde a las medidas técnicas de los vehiculos para los cuales fueron elaborados, por ello es importante, antes de comprar el artículo, verificar que corresponde a la marca, modelo y año del mismo.</i>
													</div>
												</div>
											</div>
										</div>
										<!-- bomper -->
										<!-- accesorios -->
										<div ng-if="selectedProductType == 'accesorios'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="/admin/recursos/img/accesorios/{{response.subType}}-products/{{selectedProduct.id}}/{{selectedProduct.img}}" alt="" class="img-responsive">
													<!-- <img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive"> -->
												</div>
												<br>
												<div class="row">
													<div class="col-sm-3 thumbnail-option" ng-repeat="imgItem in selectedProductImages">
														<div class="imagen">
															<img ng-src="/admin/recursos/img/accesorios/{{response.subType}}-products/{{selectedProduct.id}}/{{imgItem}}" alt="" class="img-responsive"  ng-click="changeImage(imgItem)" ng-class="{'thumbnail-option-active': selectedProduct.img == imgItem }">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-8">
														<span class="unidades text-center c-color3">Unidades
															<b class="c-blanco"  ng-if="response.subType == 'plumillas' || response.subType == 'pijamas para vehiculos'" ng-bind="selectedSize.units"></b>
															<b class="c-blanco"  ng-if="response.subType != 'plumillas' && response.subType != 'pijamas para vehiculos'" ng-bind="selectedProduct.stock"></b>
														</span>
														<div class="form-group" ng-if="response.subType == 'pijamas para vehiculos'">
															<label for="pijamaSelectedSize" class="c-blanco">Talla:</label>
															<select id="pijamaSelectedSize" name ="pijamaSelectedSize" ng-model="selectedSize" ng-options="item as item.size for item in productOptions" ng-change="$emit('UPDATE_STOCK', selectedSize)" class="form-control" required>
																<option>S</option>
																<option>M</option>
																<option>MM</option>
																<option>L</option>
																<option>XL</option>
																<option>XXL</option>
															</select>
														</div>
														<div class="form-group" ng-if="response.subType == 'plumillas'">
															<br>
															<label for="plumillaSelectedSize" class="c-blanco">Nº de plumilla:</label>
															<select id="plumillaSelectedSize" name="plumillaSelectedSize" ng-model="selectedSize" ng-options="item as item.size for item in productOptions" ng-change="$emit('UPDATE_STOCK', selectedSize)" class="form-control" required>
																<!-- <option>14</option>
																<option>15</option>
																<option>16</option>
																<option>17</option>
																<option>18</option>
																<option>19</option>
																<option>20</option>
																<option>21</option>
																<option>22</option>
																<option>23</option>
																<option>24</option>
																<option>26</option> -->
															</select>
														</div>
														<span class="c-color4" ng-if="selectedProduct.color != undefined">Color:</span> <b ng-if="selectedProduct.color != undefined" class="tamano c-blanco txt-18" >{{selectedProduct.color}}</b><br>
														<span class="c-color4">Caracteristica:</span> <b class="precio txt-15" ng-bind-html="selectedProduct.detail" ></b><br>
														<!-- <span class="c-color4" ng-if="selectedProduct.instructivo == 'si'">Instructivo:</span> <a ng-if="selectedProduct.instructivo == 'si'" href="admin/recursos/documents/instructivos/{{selectedProductType}}.pdf" target="_blank" class="tamano c-blanco txt-18" >Descargar</a><br> -->
													</div>
													<div class="col-xs-4 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12">
														<br>
														<br>
														<br>
													</div>
													<div class="col-xs-12 text-right">
														<button ng-disabled="((selectedSize == undefined) && (response.subType == 'plumillas' || response.subType == 'pijamas para vehiculos') || (selectedProduct.stock == 0 && selectedSize.units == 0))" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, selectedProductType, selectedSize, selectedProduct)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
											<div class="row" >
												<div class="col-md-12">
													<br>
													<div class="alert alert-info bg-color4" ng-if="response.subType == 'pijamas para vehiculos'">
														<i>Instructivo: La siguiente tabla muestra las medidas de largo, ancho y alto en centimetros de nuestra pijamas.</i>
														<table class="table table-striped">
															<thead>
																<tr>
																	<th>Talla</th>
																	<th>Largos</th>
																	<th>Ancho</th>
																	<th>Alto</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>S</td>
																	<td>406 cm</td>
																	<td>165 cm</td>
																	<td>124 cm</td>
																</tr>
																<tr>
																	<td>M</td>
																	<td>432 cm</td>
																	<td>165 cm</td>
																	<td>124 cm</td>
																</tr>
																<tr>
																	<td>MM</td>
																	<td>457 cm</td>
																	<td>178 cm</td>
																	<td>124 cm</td>
																</tr>
																<tr>
																	<td>L</td>
																	<td>483 cm</td>
																	<td>178 cm</td>
																	<td>124 cm</td>
																</tr>
																<tr>
																	<td>XL</td>
																	<td>533 cm</td>
																	<td>178 cm</td>
																	<td>124 cm</td>
																</tr>
																<tr>
																	<td>XXL</td>
																	<td>572 cm</td>
																	<td>203 cm</td>
																	<td>124 cm</td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="alert alert-info bg-color4" ng-if="response.subType == 'plumillas'">
														<i>Instructivo: Para conocer la medida de tus plumillas, basta con medir en centimetros la longitud de la goma y ubica el número de la plumilla en la siguiente tabla:</i>
														<table class="table table-striped">
															<thead>
																<tr>
																	<th>Nº de Plumilla</th>
																	<th>Longitud en CM</th>
																	<th>Longitud en MM</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>14</td>
																	<td>35 cm</td>
																	<td>350 MM</td>
																</tr>
																<!-- <tr>
																	<td>15</td>
																	<td>37,5 cm</td>
																	<td>375 MM</td>
																</tr> -->
																<tr>
																	<td>16</td>
																	<td>40 cm</td>
																	<td>400 MM</td>
																</tr>
																<!-- <tr>
																	<td>17</td>
																	<td>42,5 cm</td>
																	<td>425 MM</td>
																</tr> -->
																<tr>
																	<td>18</td>
																	<td>45 cm</td>
																	<td>450 MM</td>
																</tr>
																<!-- <tr>
																	<td>19</td>
																	<td>47,5 cm</td>
																	<td>475 MM</td>
																</tr> -->
																<tr>
																	<td>20</td>
																	<td>50 cm</td>
																	<td>500 MM</td>
																</tr>
																<!-- <tr>
																	<td>21</td>
																	<td>52,5 cm</td>
																	<td>525 MM</td>
																</tr> -->
																<tr>
																	<td>22</td>
																	<td>55 cm</td>
																	<td>550 MM</td>
																</tr>
																<!-- <tr>
																	<td>23</td>
																	<td>57,5 cm</td>
																	<td>575 MM</td>
																</tr> -->
																<tr>
																	<td>24</td>
																	<td>60 cm</td>
																	<td>6000 MM</td>
																</tr>
																<tr>
																	<td>26</td>
																	<td>65 cm</td>
																	<td>650 MM</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- universales -->
										<!-- seat -->
										<div ng-if="selectedProductType == 'portaequipajes'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="/admin/recursos/img/{{response.type}}-products/{{selectedProduct.id}}/{{selectedProduct.img}}" alt="" class="img-responsive">
												</div>
												<br>
												<div class="row">
													<div class="col-sm-3 thumbnail-option" ng-repeat="imgItem in selectedProductImages">
														<div class="imagen">
															<img ng-src="/admin/recursos/img/{{response.type}}-products/{{selectedProduct.id}}/{{imgItem}}" alt="" class="img-responsive"  ng-click="changeImage(imgItem)" ng-class="{'thumbnail-option-active': selectedProduct.img == imgItem }">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-8">
														<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
														<br>
														<br>
														<span class="c-color4">Caracteristica:</span> <b class="precio txt-15" ng-bind-html="selectedProduct.details" ></b><br>
													</div>
													<div class="col-xs-4 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio por articulo</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12 text-right">
														<button ng-disabled="selectedProduct.stock_unit == 0" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, 'portaequipajes', selectedProduct.size, selectedProduct)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
										</div>
										<!-- seat -->
										<!-- light -->
										<div ng-if="selectedProductType == 'light_hid'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="admin/recursos/img/light-hid-products/{{selectedProduct.img}}.gif" alt="" class="img-responsive">
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-8">
														<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock"></b></span>
														<br>
														<br>
														<span class="c-color4">Caracteristica:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.detail}}</b><br>
													</div>
													<div class="col-xs-4 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio por rin</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12 text-right">
														<button ng-disabled="selectedProduct.stock == 0" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, 'light_hid', selectedProduct.size, selectedProduct)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
										</div>
										<!-- light -->
										<!-- tank -->
										<div ng-if="selectedProductType == 'tank'" class="row producto">
											<div class="col-sm-6">
												<div class="imagen">
													<img ng-src="admin/recursos/img/accesorios/universales/{{selectedProduct.img}}.gif" alt="" class="img-responsive">
													<!-- <img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive"> -->
												</div>
											</div>
											<div class="col-sm-6">
												<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
												<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
												<br>
												<br>
												<div class="row">
													<div class="col-xs-8">
														<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock"></b></span>
														<br>
														<br>
														<span class="c-color4">Caracteristica:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.detail}}</b><br>

													</div>
													<div class="col-xs-4 text-right">
														<br>
														<br>
														<span class="c-color3 text-uppercase">Precio por rin</span><br>
														<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-xs-12 text-right">
														<button ng-disabled="selectedProduct.stock == 0" ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, 'accesorios/universales', selectedProduct.size, selectedProduct)" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
													</div>
												</div>
											</div>
										</div>
										<!-- tank -->

										<hr>

										<div class="row productos-compatibles" ng-if="selectedProductType == 'rin'">
											<div class="col-xs-12 text-center">
												<h3 class="c-color4 text-left">Llantas compatibles para tu vehículo</h3>
												<div class="text-center" ng-if="loadingCompatibles && (tiresCompatible != undefined)">
													<br>
													<p class="txt-16">cargando...</p>
													<br>
													<img src="/recursos/img/preloader-productos.gif" alt="">
												</div>
												<div ng-if="tiresCompatible == undefined && selectedProductType == 'rin'" class="alert alert-info bg-color4">
									            	<i>Sin productos Compatibles</i>
									            </div>
												<div style="height: 180px !important;" ng-show="showCompatiblesProducts && tiresCompatible.length > 0">
													<!-- <li ng-repeat="tire in tiresCompatible">
														<a ng-click="sendToProductDetail( tire, 'tire' )">
															 <img ng-src="admin/recursos/img/tire-products/{{tire.img}}.gif" alt=""><br>
															<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
															<span>{{tire.brand}} - {{tire.referencie}}</span>
														</li> -->

													<div ng-repeat="(key, tire) in tiresCompatible | limitTo:5	track by $index" style="float: left; background-color: #FFF;padding: 5px;width: 171px;margin: 0 0 0 5px;">
														<a ng-click="sendToProductDetail( tire, 'tire' )">
															<img ng-src="/admin/recursos/img/tire-products/{{tire.img}}.gif" alt="" style="width: 157px;"><br>
															<span style="font-size: 10px;">{{tire.brand}} - {{tire.referencie}}</span>
														</a>
													</div>
													<!-- <li>
														<a href="#">
															<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
															<span>205-50-R15</span>
														</a>
													</li>
													<li>
														<a href="#">
															<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
															<span>185-55-R15</span>
														</a>
													</li>
													-->
													<!-- <li>
														<a href="#">
															<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
															<span>195-50-R15</span>
														</a>
													</li>
													<li>
														<a href="#">
															<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
															<span>205-50-R15</span>
														</a>
													</li>
													<li>
														<a href="#">
															<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
															<span>185-55-R15</span>
														</a>
													</li>
													<li>
														<a href="#">
															<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
															<span>205-50-R15</span>
														</a>
													</li>
													<li>
														<a href="#">
															<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
															<span>195-50-R15</span>
														</a>
													</li>-->
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-2 text-center te-puede-interesar">
										<h5 class="text-uppercase txt-18 c-color4">Te puede interesar</h5>
										<i class="st-separador"></i>

										<div class="tipo">
											<div class="cuadro">
												<span>Tapate maletero</span>
											</div>
											<div class="foto img1">
												<a data-nombre="accesorios-accesorios" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
											</div>
										</div>
										<div class="tipo">
											<div class="cuadro">
												<span>Pijamas</span>
											</div>
											<div class="foto img2">
												<a data-nombre="accesorios-accesorios" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
											</div>
										</div>
										<div class="tipo">
											<div class="cuadro">
												<span>Plumillas</span>
											</div>
											<div class="foto img3">
												<a data-nombre="accesorios-accesorios" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
											</div>
										</div>
									</div>
								</row>
							</div>
						</div>

					</div>
				</div>
			</section>
		</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'/server/js/angularApp/angularApp.js',
		'/server/js/angularApp/controllers/productListHeaderCtrl.js',
		'/server/js/angularApp/controllers/mainSearchCtrl.js',
		'/server/js/angularApp/controllers/searchCtrl.js',
		'/server/js/angularApp/controllers/productListCtrl.js',
		'/server/js/angularApp/controllers/productDetailCtrl.js',
		'/server/js/angularApp/controllers/monthPromotionCtrl.js',
		'/server/js/angularApp/controllers/shoppingCartAuxCtrl.js',
		'/server/js/angularApp/controllers/modals/LoginSignUpCtrl.js',
		'/server/js/angularApp/controllers/modals/profileCtrl.js',
		'/server/js/angularApp/controllers/modals/shoppingCartCtrl.js',
		'/server/js/angularApp/controllers/menuProductCtrl.js',
		'/server/js/angularApp/services/constantService.js',
		'/server/js/angularApp/services/utilService.js'
	)
);

$pie = new html\Pie($opciones);

?>
