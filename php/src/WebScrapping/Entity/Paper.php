<?php

namespace Chuva\php\WebScrapping\Entity;

/**
 * The Paper class represents the row of the parsed data.
 */
class Paper {

  /**
   * Paper Id.
   *
   * @var int
   */
  public $id;

  /**
   * Paper Title.
   *
   * @var string
   */
  public $title;

  /**
   * The paper type (e.g. Poster, Nobel Prize, etc).
   *
   * @var string
   */
  public $type;

  /**
   * Paper authors.
   *
   * @var \Chuva\Php\WebScrapping\Entity\Person[]
   */
  public $authors;

  /**
   * Builder.
   */
  public function __construct($id, $title, $type, $authors = []) {
    $this->id = $id;
    $this->title = $title;
    $this->type = $type;
    $this->authors = $authors;
  }

  /**
   * Get the paper's id.
   *
   * @return int
   *   The paper's id.
   */
  public function getId(): int {
    return $this->id;
  }

  /**
   * Set the paper's id.
   *
   * @param int $id
   *   The paper's id.
   */
  public function setId(int $id): void {
    $this->id = $id;
  }

  /**
   * Get the paper's title.
   *
   * @return string
   *   The paper's title.
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * Set the paper's title.
   *
   * @param string $title
   *   The paper's title.
   */
  public function setTitle(string $title): void {
    $this->title = $title;
  }

  /**
   * Get the paper's type.
   *
   * @return string
   *   The paper's type.
   */
  public function getType(): string {
    return $this->type;
  }

  /**
   * Set the paper's type.
   *
   * @param string $type
   *   The paper's type.
   */
  public function setType(string $type): void {
    $this->type = $type;
  }

  /**
   * Get the paper's authors.
   *
   * @return \Chuva\Php\WebScrapping\Entity\Person[]
   *   The paper's authors.
   */
  public function getAuthors(): array {
    return $this->authors;
  }

  /**
   * Set the paper's authors.
   *
   * @param \Chuva\Php\WebScrapping\Entity\Person[] $authors
   *   The paper's authors.
   */
  public function setAuthors(array $authors): void {
    $this->authors = $authors;
  }

}
