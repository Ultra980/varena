<?php

class Problem extends BaseObject {
  private $html = null;

  function getHtml() {
    if ($this->html === null) {
      $p = new Parsedown();
      $this->html = $p->text($this->statement);
    }
    return $this->html;
  }
  
  /**
   * Validates a problem for correctness. Returns an array of { field => array of errors }.
   **/
  function validate() {
    $errors = [];

    if (mb_strlen($this->name) < 2) {
      $errors['name'] = _('The problem name must be at least 2 characters long.');
    }

    if (!$this->statement) {
      $errors['statement'] = _('The statement cannot be empty.');
    }

    $other = Model::factory('Problem')
           ->where('name', $this->name)
           ->where_not_equal('id', $this->id)
           ->find_one();
    if ($other) {
      $errors['name'] = _('There already exists a problem with this name.');
    }

    return $errors;
  }

}

?>
