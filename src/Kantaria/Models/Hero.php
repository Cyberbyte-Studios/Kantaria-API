<?php

namespace Kantaria\Models;

use Kantaria\Models\Base\Hero as BaseHero;

/**
 * Skeleton subclass for representing a row from the 'hero' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Hero extends BaseHero
{
	public function __construct()
	{
		parent::__construct();
		$this->setHealth(300);
		$this->setOxygen(0);
		$this->setFood(0);
		$this->setPosX(6890);
		$this->setPosY(-3370);
		$this->setPosZ(20692);
	}
}
