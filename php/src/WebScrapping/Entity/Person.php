<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person {

  /**
   * Person name.
   */
  public string $name;

  /**
   * Person institution.
   */
  public string $institution;

  /**
   * Builder.
   */
  public function __construct($name, $institution) {
    $this->name = $name;
    $this->institution = $institution;
  }

  /**
   * Get the person's name.
   *
   * @return string
   *   The person's name.
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * Set the person's name.
   *
   * @param string $name
   *   The person's name.
   */
  public function setName(string $name): void {
    $this->name = $name;
  }

  /**
   * Get the person's institution.
   *
   * @return string
   *   The person's institution.
   */
  public function getInstitution(): string {
    return $this->institution;
  }

  /**
   * Set the person's institution.
   *
   * @param string $institution
   *   The person's institution.
   */
  public function setInstitution(string $institution): void {
    $this->institution = $institution;
  }

}
