<nav class="menu-accesorios" ng-controller="menuProductCtrl">
	<ul class="text-uppercase text-center">
		<li>
			<a href="./rines" class="rines" ng-click="openProductType('rin')" data-nombre="accesorios-rines">Rines</a>
		</li>
		<li>
			<a href="./llantas" class="llantas" ng-click="openProductType('tire')" data-nombre="accesorios-llantas">Llantas</a>
		</li>
		<li>
			<a href="./accesorios" class="accesorios" ng-click="openProductType('accesorios')" data-nombre="accesorios-accesorios">Accesorios</a>
		</li>
		<li>
			<a href="./racks" class="racks" ng-click="openProductType('barrastecho')" data-nombre="accesorios-racks">Barras de Techo</a>
		</li>
		<li>
			<a href="./portaequipajes" style="font-size: 18px !important;" class="portaequipajes" ng-click="openProductType('portaequipajes')" data-nombre="accesorios-portaequipajes">Portaequipajes</a>
		</li>
		<li>
			<a href="./parrilas-para-techo" class="parrilas-para-techo" ng-click="openProductType('parrillastecho')" data-nombre="accesorios-parrilas-para-techo">Parrillas para Techo</a>
		</li>
		<li>
			<a href="./bomper-estribos" class="parrilas-bomper-estribos" ng-click="openProductType('bomberestribos')" data-nombre="accesorios-bomper-estribos">Bomber y Estribos</a>
		</li>
	</ul>
</nav>
