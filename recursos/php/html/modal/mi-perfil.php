<!-- modal -->
<div id="modal-mi-perfil" class="st-modal modal-tym" ng-controller="profileCtrl">
    <div class="contenido">
		<span class="cerrar"><i class="fa fa-remove"></i></span>
		<div class="cont">
            <div class="titulo">
                <h1>Mi Perfil</h1>
            </div>
            <div class="subtitulo">
                <h2 class="c-color4"><?= $_SESSION['user_name'] ?></h2>
                <span>Bienvenido a tu perfil</span>
            </div>

            <br>
            <h4 class="text-center" ng-bind="mainTitle"></h4>
            <br>
            <div ng-if="dataLoaded" class="table-responsive">
                <table class="tabla text-center">
                    <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>NOMBRE</th>
                            <th>PRECIO</th>
                            <th>CANTIDAD</th>
                            <th>SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="recursos/img/muestra-item-llanta.jpg" alt="imagen de producto">
                            </td>
                            <td>7618</td>
                            <td class="text-right">$180.000</td>
                            <td>4</td>
                            <td class="text-right">$720.000</td>
                        </tr>
                        <tr>
                            <td>
                                <img src="recursos/img/muestra-item-silla.jpg" alt="imagen de producto">
                            </td>
                            <td>MS-113</td>
                            <td class="text-right">$400.000</td>
                            <td>2</td>
                            <td class="text-right">$800.000</td>
                        </tr>
                        <tr class="text-right">
                            <td colspan="4">
                                <b class="txt-24 c-color3">Total:</b>
                            </td>
                            <td>
                                <b class="c-color4 txt-24">$1'920.000</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn c-blanco bg-color3 txt-12" ng-click="closeSession()">Cerrar sessión</button>
    	</div>
    </div>
</div>
