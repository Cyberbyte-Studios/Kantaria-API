<?php

namespace Kantaria\Services;

class CharacterService
{

	public static function applyDefaults($character)
	{
		$character->setHealth(300);
		return $character;
	}
}