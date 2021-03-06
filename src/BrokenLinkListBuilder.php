<?php

namespace Drupal\broken_link;

use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of Broken link redirect entity entities.
 */
class BrokenLinkListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['link'] = $this->t('Broken link');
    $header['hits'] = $this->t('Hits');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['link'] = $entity->get('link')->get(0)->getValue()['value'];
    $row['hits'] = $entity->get('hits')->get(0)->getValue()['value'];
    return $row + parent::buildRow($entity);
  }

  /**
   * Loads entity IDs using a pager sorted by the hits.
   *
   * @return array
   *   An array of entity IDs.
   */
  protected function getEntityIds() {
    $query = $this->getStorage()->getQuery()
      ->sort('hits', 'DESC');

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }
    return $query->execute();
  }

}
