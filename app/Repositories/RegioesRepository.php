<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RegioesInterface as RegioesInterface;
use App\Models\Regioes;

class RegioesRepository implements RegioesInterface
{
  /**
   * @var Model
   */
  protected $model;
 
  /**
   * Constructor
   */
  public function __construct(Regioes $model)
  {
    $this->model = $model;
  }

}
