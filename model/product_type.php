<?php
namespace Model\Product_type;

require '../../server/api/App/General.php';

Use App\General as Core;

function get_all_product_types() {
  $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "product_type ORDER BY type DESC";
  return Core\query($sql, array());
}

?>