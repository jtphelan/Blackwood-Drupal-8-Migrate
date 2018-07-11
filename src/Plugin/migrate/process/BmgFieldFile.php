<?php

namespace Drupal\bmg_migration\Plugin\migrate\process;
use Drupal\file\Plugin\migrate\process\d6\FieldFile;
use Drupal\migrate\Plugin\MigrationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @MigrateProcessPlugin(
 *   id = "bmg_d6_file"
 * )
 */
class BmgFieldFile extends FieldFile {
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration = NULL) {
    // Configure the migration process plugin to look up migrated IDs from
    // a d6 file migration.
    $migration_plugin_configuration = $configuration + [
      'migration' => 'upgrade_d6_file',
      'source' => ['fid'],
    ];

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $migration,
      $container->get('plugin.manager.migrate.process')->createInstance('migration', $migration_plugin_configuration, $migration)
    );
  }
}