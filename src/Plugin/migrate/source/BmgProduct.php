<?php
namespace Drupal\bmg_migration\Plugin\migrate\source;

use Drupal\Core\Database\Database;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drupal\commerce_migrate_ubercart\Plugin\migrate\source\uc6\Product;

 /**
 * Ubercart 6 product source.
 *
 * @MigrateSource(
 *   id = "bmg_d6_product",
 *   source_module = "uc_product"
 * )
 */
class BmgProduct extends Product {
  /**
   * {@inheritdoc}
  */
  public function prepareRow(Row $row) {

    $query = $this->select('term_data', 'td')->fields('td', ['tid']);
    $query ->join('term_node', 'tn', 'tn.tid = td.tid');
    $query ->condition('tn.nid', $row->getSourceProperty('nid'));
    //$query ->condition('td.vid', 3);
    $terms = $query ->execute()->fetchCol();
    $row->setSourceProperty('category', $terms);

    $query2 = $this->select('content_field_equipment', 'fe')->fields('fe', ['nid']);
    $query2 ->join('node', 'n', 'n.nid = fe.nid');
    $query2 ->condition('fe.field_equipment_nid', $row->getSourceProperty('nid'));
    $query2 ->condition('n.type', 'why');
    $tabs = $query2 ->execute()->fetchCol();
    $row->setSourceProperty('why_tabs', $tabs);

    return parent::prepareRow($row);
  }
}